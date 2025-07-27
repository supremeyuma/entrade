<?php

namespace App\Jobs;

use App\Models\Trade;
use App\Models\TradeBotConfig;
use App\Services\MarketDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable; // Import Throwable for more robust catch

class GenerateHistoricalTradesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $config;

    public function __construct(TradeBotConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Execute the job.
     *
     * @param MarketDataService $marketDataService
     * @return void
     */
    public function handle(MarketDataService $marketDataService)
    {
        $configId = $this->config->id;
        $this->config->appendLog("🔁 Starting trade generation for config ID: {$configId} (Hindsight Optimization Mode)");

        $this->config->update(['status' => 'processing']);

        try {
            Log::info("Inside try block for config ID: {$configId}");

            $batchId = Str::uuid()->toString();
            $this->config->appendLog("🆔 Batch ID for this run: " . $batchId);
            Log::info("Batch ID generated: {$batchId}");

            $startDate = Carbon::parse($this->config->start_date)->startOfDay();
            $endDate = Carbon::parse($this->config->end_date)->endOfDay();
            $desiredRoiPercentage = (float) $this->config->roi;
            $marketsConfig = $this->config->markets;
            $tradingPairsRaw = $this->config->trading_pairs;
            $assignToTraderId = $this->config->assign_to;
            $tradeIntervalString = $this->config->timeframe; // Defines the "opportunity window"
            $riskPerTradePercentage = (float) $this->config->risk_per_trade;
            $desiredWinRate = (float) ($this->config->desired_win_rate ?? 70); // Default to 70% if not set
            $maxTrades = (int) ($this->config->max_trades ?? 100); // Default to 100 trades if not set
            $exportCsv = $this->config->export_csv ?? false;

            // --- Determine the number of 1-minute candles to scan for each trade ---
            $scanWindowInMinutes = 0;
            if (Str::endsWith($tradeIntervalString, 'min')) {
                $scanWindowInMinutes = (int) Str::before($tradeIntervalString, 'min');
            } elseif (Str::endsWith($tradeIntervalString, 'h')) {
                $scanWindowInMinutes = (int) Str::before($tradeIntervalString, 'h') * 60;
            } elseif ($tradeIntervalString === '1d') {
                $scanWindowInMinutes = 24 * 60; // 1 day = 1440 minutes
            }
            if ($scanWindowInMinutes === 0) {
                 throw new \InvalidArgumentException("Invalid or unsupported trade interval string: {$tradeIntervalString}.");
            }
            Log::info("Scan window set to {$scanWindowInMinutes} minutes.");

            // Normalize trading pairs
            $tradingSymbols = [];
            if (!empty($tradingPairsRaw)) {
                if (is_array($tradingPairsRaw)) {
                    foreach ($tradingPairsRaw as $pairString) {
                        $exploded = array_map('trim', explode(',', $pairString));
                        $tradingSymbols = array_merge($tradingSymbols, $exploded);
                    }
                } elseif (is_string($tradingPairsRaw)) {
                    $tradingSymbols = array_map('trim', explode(',', $tradingPairsRaw));
                }
                $tradingSymbols = array_filter(array_unique($tradingSymbols));
            }

            if (empty($tradingSymbols)) {
                $this->config->appendLog("❌ No valid trading pairs found for simulation. Aborting.");
                $this->config->update(['status' => 'failed', 'notes' => 'No valid trading pairs provided.']);
                return;
            }

            $potentialWinningTrades = [];
            $potentialLosingTrades = []; // Trades that would hit SL without hitting TP first
            $potentialOtherTrades = []; // Trades that don't hit TP or SL within window

            foreach ($tradingSymbols as $symbol) {
                $marketTypeForSymbol = null;
                if (in_array('crypto', $marketsConfig) && Str::contains($symbol, '/')) {
                    $marketTypeForSymbol = 'crypto';
                } elseif (in_array('forex', $marketsConfig) && Str::contains($symbol, '/')) {
                    $marketTypeForSymbol = 'forex';
                } elseif (in_array('stocks', $marketsConfig) && !Str::contains($symbol, '/')) {
                    $marketTypeForSymbol = 'stocks';
                }

                if (!$marketTypeForSymbol) {
                    $this->config->appendLog("⚠️ Could not determine market type for symbol '{$symbol}'. Skipping.");
                    Log::warning("Could not determine market type for symbol '{$symbol}'. Skipping.");
                    continue;
                }

                $this->config->appendLog("📈 Fetching granular data for {$symbol} (Market: {$marketTypeForSymbol})...");
                Log::info("Fetching 1-minute OHLCV data for {$symbol} (Market: {$marketTypeForSymbol}, From: {$startDate->toDateString()}, To: {$endDate->toDateString()})");

                $granularOhlcvData = $marketDataService->getOhlcvData(
                    $symbol,
                    $marketTypeForSymbol,
                    '1min', // Always request 1-minute data for detailed simulation
                    $startDate->toDateString(),
                    $endDate->toDateString()
                );

                if (empty($granularOhlcvData)) {
                    $this->config->appendLog("⚠️ No granular (1-min) OHLCV data found for {$symbol}. Skipping.");
                    Log::warning("No 1-min OHLCV data found for {$symbol}. Skipping.");
                    continue;
                }

                $this->config->appendLog("Fetched " . count($granularOhlcvData) . " 1-minute data points for {$symbol}. Analyzing opportunities...");

                $numCandles = count($granularOhlcvData);
                for ($i = 0; $i < $numCandles; $i++) {
                    $entryCandle = $granularOhlcvData[$i];
                    $entryPrice = (float) $entryCandle['open'];
                    $entryTimestamp = $entryCandle['timestamp'];

                    if ($entryPrice <= 0) {
                        continue;
                    }

                    $takeProfitLevel = $entryPrice * (1 + ($desiredRoiPercentage / 100));
                    $stopLossLevel = $entryPrice * (1 - ($riskPerTradePercentage / 100));

                    $highestPriceInWindow = $entryPrice;
                    $lowestPriceInWindow = $entryPrice;
                    $exitPrice = $entryCandle['close']; // Default exit if no TP/SL hit
                    $exitTimestamp = $entryTimestamp;
                    $outcome = 'no_hit'; // 'win', 'loss', 'no_hit' (meaning expired by time)

                    // Scan window starting from the *next* candle (i+1) for better realism,
                    // or from current (i) if you allow immediate TP/SL on open price.
                    // For "playing god", we include the current candle's high/low for immediate hits.
                    for ($j = $i; $j < min($i + $scanWindowInMinutes, $numCandles); $j++) {
                        $currentCandle = $granularOhlcvData[$j];
                        $candleHigh = (float) $currentCandle['high'];
                        $candleLow = (float) $currentCandle['low'];
                        $candleClose = (float) $currentCandle['close'];
                        $currentTimestamp = $currentCandle['timestamp'];

                        $highestPriceInWindow = max($highestPriceInWindow, $candleHigh);
                        $lowestPriceInWindow = min($lowestPriceInWindow, $candleLow);

                        $exitPrice = $candleClose; // Keep updating default exit price
                        $exitTimestamp = $currentTimestamp;
                    }

                    // --- Determine the "hindsight" outcome for this entry point ---
                    $achievedTP = $highestPriceInWindow >= $takeProfitLevel;
                    $achievedSL = $lowestPriceInWindow <= $stopLossLevel;

                    if ($achievedTP && !$achievedSL) {
                        // Definitely a winning opportunity
                        $outcome = 'win';
                        $profitPercentage = $desiredRoiPercentage;
                        $finalExitPrice = $takeProfitLevel;
                    } elseif ($achievedSL && !$achievedTP) {
                         // Definitely a losing opportunity (SL hit before TP was ever possible)
                        $outcome = 'loss';
                        $profitPercentage = -$riskPerTradePercentage;
                        $finalExitPrice = $stopLossLevel;
                    } elseif ($achievedTP && $achievedSL) {
                        // Both were hit. For "playing god", we prioritize the win if possible.
                        // This assumes you would always pick the win if both were possible.
                        // If TP level is reached and SL level is also reached within the same window,
                        // it's complicated. For "playing god", we can choose the win.
                        // Or, if you want realistic "first hit", you'd track min/max of current candle.
                        // For simplicity in "playing god" mode, if TP was available, we take it.
                        $outcome = 'win'; // Prioritize winning trade
                        $profitPercentage = $desiredRoiPercentage;
                        $finalExitPrice = $takeProfitLevel;

                    } else {
                        // Neither TP nor SL was hit within the window. Close at final window price.
                        $outcome = 'time_exit';
                        $profitPercentage = (($exitPrice - $entryPrice) / $entryPrice) * 100;
                        $finalExitPrice = $exitPrice;
                    }


                    $tradeRecord = [
                        'pair' => $symbol,
                        'profit_percentage' => round($profitPercentage, 4),
                        'entry_price' => round($entryPrice, 4),
                        'exit_price' => round($finalExitPrice, 4),
                        'trade_date' => $entryTimestamp, // Entry timestamp
                        'source' => 'bot_hindsight',
                        'trader_id' => $assignToTraderId,
                        'market' => $marketTypeForSymbol,
                        'batch_id' => $batchId,
                        'created_at' => now(),
                        'updated_at' => now(),
                        'outcome' => $outcome // 'win', 'loss', 'time_exit'
                    ];

                    // Store potential trades based on their outcome
                    if ($outcome === 'win') {
                        $potentialWinningTrades[] = $tradeRecord;
                    } elseif ($outcome === 'loss') {
                        $potentialLosingTrades[] = $tradeRecord;
                    } else {
                         // Trades that neither hit TP nor SL explicitly, just expired.
                         // We might still use these if needed to fill up max_trades or adjust win rate.
                        $potentialOtherTrades[] = $tradeRecord;
                    }
                } // End of inner loop through granular data
            } // End of outer loop through trading symbols

            // --- The "Playing God" Selection Logic ---
            $allSelectedTrades = [];
            $numDesiredWins = round($maxTrades * ($desiredWinRate / 100));
            $numDesiredLosses = $maxTrades - $numDesiredWins;
            $remainingTradesToFill = $maxTrades;

            // 1. Select winning trades first
            shuffle($potentialWinningTrades); // Randomize selection
            $selectedWins = array_splice($potentialWinningTrades, 0, min($numDesiredWins, count($potentialWinningTrades)));
            $allSelectedTrades = array_merge($allSelectedTrades, $selectedWins);
            $remainingTradesToFill -= count($selectedWins);

            // 2. Select losing trades
            if ($remainingTradesToFill > 0) {
                shuffle($potentialLosingTrades); // Randomize selection
                $selectedLosses = array_splice($potentialLosingTrades, 0, min($numDesiredLosses, count($potentialLosingTrades), $remainingTradesToFill));
                $allSelectedTrades = array_merge($allSelectedTrades, $selectedLosses);
                $remainingTradesToFill -= count($selectedLosses);
            }

            // 3. Fill any remaining slots with 'time_exit' trades or more wins/losses if available
            if ($remainingTradesToFill > 0) {
                 // Combine remaining potential trades
                $remainingPotentialTrades = array_merge($potentialWinningTrades, $potentialLosingTrades, $potentialOtherTrades);
                shuffle($remainingPotentialTrades);
                $fillTrades = array_splice($remainingPotentialTrades, 0, $remainingTradesToFill);
                $allSelectedTrades = array_merge($allSelectedTrades, $fillTrades);
            }

            // Shuffle final selection to mix wins and losses for more natural distribution in DB
            shuffle($allSelectedTrades);

            $totalSimulatedTrades = count($allSelectedTrades);
            $actualWinningTradesCount = 0;
            $totalRoiAchieved = 0;

            foreach ($allSelectedTrades as &$trade) { // Use & to modify in place
                // Update the 'status' column for the database insertion
                if ($trade['outcome'] === 'win') {
                    $trade['status'] = 'win';
                    $actualWinningTradesCount++;
                } elseif ($trade['outcome'] === 'loss') {
                    $trade['status'] = 'loss';
                } else {
                    $trade['status'] = 'neutral'; // Or 'closed_by_time'
                }
                $totalRoiAchieved += $trade['profit_percentage'];
                unset($trade['outcome']); // Remove temporary 'outcome' key before insertion
            }


            if (!empty($allSelectedTrades)) {
                Trade::insert($allSelectedTrades);
                $this->config->appendLog("✅ Successfully inserted " . count($allSelectedTrades) . " hindsight-optimized trades into the database.");
                Log::info("Successfully inserted " . count($allSelectedTrades) . " hindsight-optimized trades for config ID: {$configId}");
            } else {
                $this->config->appendLog("⚠️ No trades could be generated based on the criteria. Check parameters or data availability.");
                Log::warning("No trades generated for config ID: {$configId}.");
            }

            // Calculate final metrics based on the *selected* trades
            $actualWinRate = $totalSimulatedTrades > 0 ? round(($actualWinningTradesCount / $totalSimulatedTrades) * 100, 2) : 0;
            $actualAvgRoi = $totalSimulatedTrades > 0 ? round($totalRoiAchieved / $totalSimulatedTrades, 2) : 0;

            $this->config->appendLog("✅ Completed hindsight optimization for all symbols.");
            $this->config->appendLog("📊 Total Trades Generated: {$totalSimulatedTrades}");
            $this->config->appendLog("📊 Winning Trades: {$actualWinningTradesCount}");
            $this->config->appendLog("📊 Actual Win Rate: {$actualWinRate}% (Desired: {$desiredWinRate}%)");
            $this->config->appendLog("📊 Actual Average ROI per Trade: {$actualAvgRoi}% (Desired Individual Trade ROI: {$desiredRoiPercentage}%)");

            // --- CSV Export Logic ---
            if ($exportCsv && !empty($allSelectedTrades)) {
                $csvFileName = "hindsight_trades_config_{$configId}_" . now()->format('YmdHis') . ".csv";
                $csvPath = 'exports/' . $csvFileName;

                $formattedTradesForCsv = array_map(function($tradeRow) {
                    $tradeRow['trade_date'] = $tradeRow['trade_date']->format('Y-m-d H:i:s');
                    $tradeRow['created_at'] = $tradeRow['created_at']->format('Y-m-d H:i:s');
                    $tradeRow['updated_at'] = $tradeRow['updated_at']->format('Y-m-d H:i:s');
                    return $tradeRow;
                }, $allSelectedTrades);

                $headers = array_keys($formattedTradesForCsv[0]);
                $file = fopen(storage_path('app/' . $csvPath), 'w');
                fputcsv($file, $headers);

                foreach ($formattedTradesForCsv as $tradeRow) {
                    fputcsv($file, $tradeRow);
                }
                fclose($file);

                $this->config->appendLog("📁 Trades exported to CSV: " . $csvPath);
            }

            $this->config->update([
                'status' => 'completed',
                'actual_roi' => $actualAvgRoi,
                'total_trades_generated' => $totalSimulatedTrades,
                'win_rate' => $actualWinRate,
            ]);

        } catch (Throwable $e) { // Catch Throwable for more general error handling
            $this->config->appendLog("❌ An error occurred during trade generation: " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile());
            Log::error("GenerateHistoricalTradesJob failed for config ID {$configId}: " . $e->getMessage(), ['exception' => $e]);
            $this->config->update(['status' => 'failed', 'notes' => 'Error during job execution: ' . $e->getMessage()]);
        }
    }
}