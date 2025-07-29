<?php

namespace App\Jobs;

use App\Models\Trade;
use App\Models\TradeBotConfig;
use App\Services\MarketDataService;
use App\Models\OhlcvData; // <-- NEW: Import OhlcvData model
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr; // <-- NEW: Import Arr helper
use Throwable;

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
        $this->config->appendLog("🔁 Starting trade generation for config ID: {$configId} (Historical Fiction Mode)");

        $this->config->update(['status' => 'processing']);

        try {
            Log::info("Inside try block for config ID: {$configId}");

            $batchId = Str::uuid()->toString();
            $this->config->appendLog("🆔 Batch ID for this run: " . $batchId);
            Log::info("Batch ID generated: {$batchId}");

            $desiredRoiPercentage = (float) $this->config->roi;
            $riskPerTradePercentage = (float) $this->config->risk_per_trade;
            $desiredWinRate = (float) ($this->config->desired_win_rate ?? 70);
            $maxTrades = (int) ($this->config->max_trades ?? 100);
            $exportCsv = $this->config->export_csv ?? false;
            $minTradeDurationDays = (int) ($this->config->min_trade_duration_days ?? 1); // NEW
            $maxTradeDurationDays = (int) ($this->config->max_trade_duration_days ?? 5); // NEW

            // Normalize trading pairs from config
            $tradingSymbols = [];
            if (!empty($this->config->trading_pairs)) {
                if (is_array($this->config->trading_pairs)) {
                    foreach ($this->config->trading_pairs as $pairString) {
                        $exploded = array_map('trim', explode(',', $pairString));
                        $tradingSymbols = array_merge($tradingSymbols, $exploded);
                    }
                } elseif (is_string($this->config->trading_pairs)) {
                    $tradingSymbols = array_map('trim', explode(',', $this->config->trading_pairs));
                }
                $tradingSymbols = array_filter(array_unique($tradingSymbols));
            }

            if (empty($tradingSymbols)) {
                $this->config->appendLog("❌ No valid trading pairs found for simulation. Aborting.");
                $this->config->update(['status' => 'failed', 'notes' => 'No valid trading pairs provided.']);
                return;
            }

            // Get the overall date range of available data in your database
            $availableDataMinTimestamp = OhlcvData::min('timestamp');
            $availableDataMaxTimestamp = OhlcvData::max('timestamp');

            if (!$availableDataMinTimestamp || !$availableDataMaxTimestamp) {
                $this->config->appendLog("⚠️ No OHLCV data found in the database. Please run the `DownloadDailyOhlcvDataJob` or ensure data is present. Aborting.");
                $this->config->update(['status' => 'failed', 'notes' => 'No OHLCV data found in database.']);
                return;
            }

            $dataStartDate = Carbon::parse($availableDataMinTimestamp)->startOfDay();
            $dataEndDate = Carbon::parse($availableDataMaxTimestamp)->endOfDay();

            $this->config->appendLog("📊 Using OHLCV data from {$dataStartDate->toDateString()} to {$dataEndDate->toDateString()} from local database.");

            $generatedTrades = [];
            $winningTradeCandidates = [];
            $losingTradeCandidates = [];
            $neutralTradeCandidates = [];

            $attempts = 0;
            $maxGenerationAttempts = $maxTrades * 5; // Allow more attempts to find plausible trades

            // --- Main Trade Generation Loop ---
            while (count($generatedTrades) < $maxTrades && $attempts < $maxGenerationAttempts) {
                $attempts++;

                // 1. Randomly select a trading pair
                $selectedSymbol = Arr::random($tradingSymbols);
                $marketTypeForSymbol = null;
                if (in_array('crypto', $this->config->markets) && Str::contains($selectedSymbol, '/')) {
                    $marketTypeForSymbol = 'crypto';
                } elseif (in_array('forex', $this->config->markets) && Str::contains($selectedSymbol, '/')) {
                    $marketTypeForSymbol = 'forex';
                } elseif (in_array('stocks', $this->config->markets) && !Str::contains($selectedSymbol, '/')) {
                    $marketTypeForSymbol = 'stocks';
                }

                if (!$marketTypeForSymbol) {
                    Log::warning("Could not determine market type for symbol '{$selectedSymbol}'. Skipping.");
                    continue;
                }

                // 2. Randomly determine trade duration
                $tradeDuration = rand($minTradeDurationDays, $maxTradeDurationDays);

                // 3. Randomly select an entry date within the available data range
                // Ensure there's enough room for the trade duration
                $maxPossibleStartDate = $dataEndDate->copy()->subDays($tradeDuration);
                if ($maxPossibleStartDate->lt($dataStartDate)) {
                    Log::warning("Not enough data history to simulate a trade of {$tradeDuration} days for {$selectedSymbol}. Skipping.");
                    continue; // Not enough data for this duration
                }

                $entryDate = Carbon::createFromTimestamp(
                    rand($dataStartDate->timestamp, $maxPossibleStartDate->timestamp)
                )->startOfDay();

                $exitDate = $entryDate->copy()->addDays($tradeDuration);

                // 4. Retrieve OHLCV data for the entire trade duration from the database
                $ohlcvDataForDuration = OhlcvData::where('symbol', $selectedSymbol)
                                            ->where('market_type', $marketTypeForSymbol)
                                            ->where('interval', '1d')
                                            ->whereBetween('timestamp', [$entryDate, $exitDate])
                                            ->orderBy('timestamp', 'asc')
                                            ->get();

                if ($ohlcvDataForDuration->count() < ($tradeDuration + 1)) {
                    // Not enough continuous data for the selected duration, likely missing days
                    Log::warning("Insufficient continuous OHLCV data for {$selectedSymbol} between {$entryDate->toDateString()} and {$exitDate->toDateString()}. Skipping.");
                    continue;
                }

                // Determine max high and min low during the entire trade duration
                $maxHighDuringDuration = $ohlcvDataForDuration->max('high');
                $minLowDuringDuration = $ohlcvDataForDuration->min('low');

                // Placeholder for the actual trade generation function
                // This function will attempt to create a plausible trade based on the data
                // We'll implement this function in the next step.
                $trade = $this->generateFictionalTrade(
                    $selectedSymbol,
                    $marketTypeForSymbol,
                    $desiredRoiPercentage,
                    $riskPerTradePercentage,
                    $ohlcvDataForDuration->toArray(), // Pass as array for simpler access
                    $entryDate,
                    $exitDate,
                    $tradeDuration,
                    $maxHighDuringDuration,
                    $minLowDuringDuration
                );

                if ($trade) {
                    $trade['batch_id'] = $batchId;
                    $trade['source'] = 'bot_historical_fiction';
                    $trade['trader_id'] = $this->config->assign_to;
                    $trade['created_at'] = now();
                    $trade['updated_at'] = now();

                    // Categorize generated trade for final selection
                    if ($trade['status'] === 'win') {
                        $winningTradeCandidates[] = $trade;
                    } elseif ($trade['status'] === 'loss') {
                        $losingTradeCandidates[] = $trade;
                    } else {
                        $neutralTradeCandidates[] = $trade;
                    }
                    $generatedTrades[] = $trade; // Add to overall generated count
                } else {
                    Log::debug("Failed to generate a plausible trade after an attempt.");
                }
            } // End of while loop for trade generation

            // --- The "Playing God" Selection Logic (remains largely the same) ---
            $allSelectedTrades = [];
            $numDesiredWins = round($maxTrades * ($desiredWinRate / 100));
            $numDesiredLosses = $maxTrades - $numDesiredWins;
            $remainingTradesToFill = $maxTrades;

            shuffle($winningTradeCandidates);
            $selectedWins = array_splice($winningTradeCandidates, 0, min($numDesiredWins, count($winningTradeCandidates)));
            $allSelectedTrades = array_merge($allSelectedTrades, $selectedWins);
            $remainingTradesToFill -= count($selectedWins);

            if ($remainingTradesToFill > 0) {
                shuffle($losingTradeCandidates);
                $selectedLosses = array_splice($losingTradeCandidates, 0, min($numDesiredLosses, count($losingTradeCandidates), $remainingTradesToFill));
                $allSelectedTrades = array_merge($allSelectedTrades, $selectedLosses);
                $remainingTradesToFill -= count($selectedLosses);
            }

            if ($remainingTradesToFill > 0) {
                $remainingPotentialTrades = array_merge($winningTradeCandidates, $losingTradeCandidates, $neutralTradeCandidates);
                shuffle($remainingPotentialTrades);
                $fillTrades = array_splice($remainingPotentialTrades, 0, min($remainingTradesToFill, count($remainingPotentialTrades)));
                $allSelectedTrades = array_merge($allSelectedTrades, $fillTrades);
            }

            shuffle($allSelectedTrades); // Final shuffle for presentation order

            $totalSimulatedTrades = count($allSelectedTrades);
            $actualWinningTradesCount = 0;
            $totalRoiAchieved = 0;

            foreach ($allSelectedTrades as $trade) {
                if ($trade['status'] === 'win') {
                    $actualWinningTradesCount++;
                }
                $totalRoiAchieved += $trade['profit_percentage'];
            }

            if (!empty($allSelectedTrades)) {
                Trade::insert($allSelectedTrades);
                $this->config->appendLog("✅ Successfully inserted " . count($allSelectedTrades) . " historical fiction trades into the database.");
                Log::info("Successfully inserted " . count($allSelectedTrades) . " historical fiction trades for config ID: {$configId}");
            } else {
                $this->config->appendLog("⚠️ No trades could be generated based on the criteria. Check parameters, data availability, or increase max generation attempts.");
                Log::warning("No trades generated for config ID: {$configId}.");
            }

            $actualWinRate = $totalSimulatedTrades > 0 ? round(($actualWinningTradesCount / $totalSimulatedTrades) * 100, 2) : 0;
            $actualAvgRoi = $totalSimulatedTrades > 0 ? round($totalRoiAchieved / $totalSimulatedTrades, 2) : 0;

            $this->config->appendLog("✅ Completed historical fiction generation for all symbols.");
            $this->config->appendLog("📊 Total Trades Generated: {$totalSimulatedTrades}");
            $this->config->appendLog("📊 Winning Trades: {$actualWinningTradesCount}");
            $this->config->appendLog("📊 Actual Win Rate: {$actualWinRate}% (Desired: {$desiredWinRate}%)");
            $this->config->appendLog("📊 Actual Average ROI per Trade: {$actualAvgRoi}% (Desired Individual Trade ROI: {$desiredRoiPercentage}%)");

            // --- CSV Export Logic (remains similar) ---
            if ($exportCsv && !empty($allSelectedTrades)) {
                $csvFileName = "historical_fiction_trades_config_{$configId}_" . now()->format('YmdHis') . ".csv";
                $csvPath = 'exports/' . $csvFileName;

                $formattedTradesForCsv = array_map(function($tradeRow) {
                    // Ensure Carbon instances are correctly formatted for CSV
                    if ($tradeRow['trade_date'] instanceof Carbon) {
                        $tradeRow['trade_date'] = $tradeRow['trade_date']->format('Y-m-d H:i:s');
                    }
                    if ($tradeRow['entry_timestamp'] instanceof Carbon) {
                        $tradeRow['entry_timestamp'] = $tradeRow['entry_timestamp']->format('Y-m-d H:i:s');
                    }
                    if ($tradeRow['exit_timestamp'] instanceof Carbon) {
                        $tradeRow['exit_timestamp'] = $tradeRow['exit_timestamp']->format('Y-m-d H:i:s');
                    }
                    $tradeRow['created_at'] = $tradeRow['created_at']->format('Y-m-d H:i:s');
                    $tradeRow['updated_at'] = $tradeRow['updated_at']->format('Y-m-d H:i:s');
                    return $tradeRow;
                }, $allSelectedTrades);

                if (!empty($formattedTradesForCsv)) {
                    $headers = array_keys($formattedTradesForCsv[0]);
                    $file = fopen(storage_path('app/' . $csvPath), 'w');
                    fputcsv($file, $headers);

                    foreach ($formattedTradesForCsv as $tradeRow) {
                        fputcsv($file, $tradeRow);
                    }
                    fclose($file);

                    $this->config->appendLog("📁 Trades exported to CSV: " . $csvPath);
                }
            }

            $this->config->update([
                'status' => 'completed',
                'actual_roi' => $actualAvgRoi,
                'total_trades_generated' => $totalSimulatedTrades,
                'win_rate' => $actualWinRate,
            ]);

        } catch (Throwable $e) {
            $this->config->appendLog("❌ An error occurred during trade generation: " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile());
            Log::error("GenerateHistoricalTradesJob failed for config ID {$configId}: " . $e->getMessage(), ['exception' => $e]);
            $this->config->update(['status' => 'failed', 'notes' => 'Error during job execution: ' . $e->getMessage()]);
        }
    }

    /**
     * Placeholder for the fictional trade generation logic.
     * This method will be implemented in the next step.
     *
     * @return array|null Returns a generated trade array, or null if a plausible trade could not be generated.
     */
    /**
     * Generates a single plausible fictional trade.
     *
     * @param string $symbol
     * @param string $marketType
     * @param float $desiredRoiPercentage
     * @param float $riskPerTradePercentage
     * @param array $ohlcvDataForDuration Array of daily OHLCV candles covering the trade duration.
     * @param Carbon $entryDayCandleTimestamp The timestamp of the day the trade starts.
     * @param Carbon $exitDayCandleTimestamp The timestamp of the day the trade ends.
     * @param int $tradeDurationDays The number of days the trade is set to run for.
     * @param float $maxHighDuringDuration The absolute highest price during the trade duration.
     * @param float $minLowDuringDuration The absolute lowest price during the trade duration.
     * @return array|null Returns a generated trade array, or null if a plausible trade could not be generated.
     */
    protected function generateFictionalTrade(
        string $symbol,
        string $marketType,
        float $desiredRoiPercentage,
        float $riskPerTradePercentage,
        array $ohlcvDataForDuration,
        Carbon $entryDayCandleTimestamp,
        Carbon $exitDayCandleTimestamp,
        int $tradeDurationDays,
        float $maxHighDuringDuration,
        float $minLowDuringDuration
    ): ?array {
        // Pick a random side for future expansion, currently assumed long for simpler example
        $side = 'long'; // For now, we'll primarily simulate long trades.

        // Get the actual OHLC of the entry day from the provided data
        $entryCandleData = Arr::first($ohlcvDataForDuration, fn($candle) => Carbon::createFromTimestampMs($candle['t'])->startOfDay()->eq($entryDayCandleTimestamp->startOfDay()));
        if (!$entryCandleData) {
            Log::debug("No entry candle data found for {$symbol} on {$entryDayCandleTimestamp->toDateString()}.");
            return null;
        }

        $entryOpen = (float) $entryCandleData['o'];
        $entryHigh = (float) $entryCandleData['h'];
        $entryLow = (float) $entryCandleData['l'];
        $entryClose = (float) $entryCandleData['c'];

        // Generate entry_timestamp: Random time within the entry day (e.g., between 9 AM and 5 PM for market hours, 24h for crypto)
        $entryTime = Carbon::parse($entryDayCandleTimestamp)->setTime(rand(9, 17), rand(0, 59), rand(0, 59));

        // Generate entry_price: Plausible price within the entry day's OHLC
        // Simple approach: a random price between the day's open and close, or low/high.
        // More realistic: bias towards open if early, close if late.
        $entryPrice = round(rand($entryLow * 100, $entryHigh * 100) / 100, 4);
        // Ensure entry price is within reasonable bounds (e.g., not drastically outside open/close range for general realism)
        if ($entryPrice < min($entryOpen, $entryClose) * 0.9 || $entryPrice > max($entryOpen, $entryClose) * 1.1) {
             $entryPrice = round(rand(min($entryOpen, $entryClose) * 100, max($entryOpen, $entryClose) * 100) / 100, 4);
        }
        // Fallback for extreme cases
        if ($entryPrice < $entryLow) $entryPrice = $entryLow;
        if ($entryPrice > $entryHigh) $entryPrice = $entryHigh;


        // Calculate target profit and stop loss prices
        $targetProfitPrice = $entryPrice * (1 + ($desiredRoiPercentage / 100));
        $stopLossPrice = $entryPrice * (1 - ($riskPerTradePercentage / 100));

        $actualExitPrice = null;
        $exitTimestamp = null;
        $tradeStatus = 'neutral';
        $profitPercentage = 0;

        // --- Simulate Trade Progression and Determine Exit ---
        // Iterate through the duration to find if TP or SL was hit
        $foundExit = false;
        foreach ($ohlcvDataForDuration as $index => $candle) {
            $currentCandleTimestamp = Carbon::createFromTimestampMs($candle['t']);
            $currentOpen = (float) $candle['o'];
            $currentHigh = (float) $candle['h'];
            $currentLow = (float) $candle['l'];
            $currentClose = (float) $candle['c'];

            // Skip the entry day for exit calculation if trade started on that day
            if ($currentCandleTimestamp->eq($entryDayCandleTimestamp) && $index === 0) {
                 // For 1-day trades, the exit can occur on the same day as entry.
                 // For multi-day, only consider exit on subsequent days.
                 if ($tradeDurationDays > 0) continue; // For multi-day, exit won't be on day 0
            }

            // Simulate intraday price action (simplified)
            // We assume prices move from Open, hit Low, then High, then Close (or vice versa)
            // Check if target profit was hit
            if ($side === 'long') {
                if ($currentHigh >= $targetProfitPrice) {
                    $actualExitPrice = $targetProfitPrice;
                    $tradeStatus = 'win';
                    $profitPercentage = $desiredRoiPercentage;
                    $exitTimestamp = $this->getPlausibleIntradayTimestamp($currentCandleTimestamp, $currentOpen, $currentHigh, $currentLow, $currentClose, $actualExitPrice);
                    $foundExit = true;
                    break;
                }
                // Check if stop loss was hit
                if ($currentLow <= $stopLossPrice) {
                    $actualExitPrice = $stopLossPrice;
                    $tradeStatus = 'loss';
                    $profitPercentage = -$riskPerTradePercentage;
                    $exitTimestamp = $this->getPlausibleIntradayTimestamp($currentCandleTimestamp, $currentOpen, $currentHigh, $currentLow, $currentClose, $actualExitPrice);
                    $foundExit = true;
                    break;
                }
            }
            // (Add 'short' side logic here later if needed)
        }

        // If no TP/SL hit within the simulated duration, it's a "time exit"
        if (!$foundExit) {
            $tradeStatus = 'neutral'; // Or 'time_exit' if you add a specific status
            $lastCandle = Arr::last($ohlcvDataForDuration);
            if ($lastCandle) {
                $actualExitPrice = (float) $lastCandle['close'];
                $profitPercentage = (($actualExitPrice - $entryPrice) / $entryPrice) * 100;
                $exitTimestamp = Carbon::parse($lastCandle['t'])->endOfDay()->subMinutes(rand(1,60)); // Exit near end of last day
            } else {
                Log::error("Failed to determine last candle for time exit on {$symbol}.");
                return null; // Should not happen if ohlcvDataForDuration is valid
            }
        }

        // Ensure exit_timestamp is after entry_timestamp
        if ($exitTimestamp->lt($entryTime)) {
            // If exit happened on the same day but the calculated time is before entry,
            // adjust to be slightly after entry time.
            if ($exitTimestamp->copy()->startOfDay()->eq($entryTime->copy()->startOfDay())) {
                $exitTimestamp = $entryTime->copy()->addMinutes(rand(10, 60)); // At least 10-60 minutes after entry
            } else {
                // This scenario means something is wrong with the logic or data for multi-day trades.
                // For now, let's make it null to indicate implausibility.
                Log::warning("Generated exit timestamp {$exitTimestamp} is before entry {$entryTime} for {$symbol}. Discarding trade.");
                return null;
            }
        }


        // Final trade data structure
        return [
            'pair' => $symbol,
            'profit_percentage' => round($profitPercentage, 4),
            'entry_price' => round($entryPrice, 4),
            'exit_price' => round($actualExitPrice, 4),
            'trade_date' => $entryDayCandleTimestamp, // This is still for the main 'trade_date' column, consider using entry_timestamp for sorting too.
            'entry_timestamp' => $entryTime,
            'exit_timestamp' => $exitTimestamp,
            'market' => $marketType,
            'status' => $tradeStatus,
            'trade_duration_days' => $tradeDurationDays,
        ];
    }

    /**
     * Generates a plausible intraday timestamp for a given price based on daily OHLC.
     * Simplistic approach: assumes price moves linearly or in typical patterns (open-low-high-close).
     * For daily candles, 9 AM to 5 PM (8 hours) can be used as the trading window for stocks, or 24h for crypto.
     *
     * @param Carbon $candleTimestamp The start of the day for the candle.
     * @param float $open
     * @param float $high
     * @param float $low
     * @param float $close
     * @param float $targetPrice
     * @return Carbon
     */
    protected function getPlausibleIntradayTimestamp(Carbon $candleTimestamp, float $open, float $high, float $low, float $close, float $targetPrice): Carbon
    {
        $startOfDay = $candleTimestamp->copy()->setTime(9, 0, 0); // Start of main trading hours for stocks, or 0,0,0 for crypto
        $endOfDay = $candleTimestamp->copy()->setTime(17, 0, 0);   // End of main trading hours for stocks, or 23,59,59 for crypto

        // For crypto, use full 24 hours
        if (Str::contains($this->config->markets, 'crypto')) { // Assuming you can check config->markets here or pass a flag
             $startOfDay = $candleTimestamp->copy()->startOfDay();
             $endOfDay = $candleTimestamp->copy()->endOfDay();
        }

        // Ensure target price is within the candle's range for this function
        $targetPrice = max($low, min($high, $targetPrice));

        // Simple linear interpolation of time based on price.
        // This is very rudimentary but provides a random time within the day.
        // A more advanced model would simulate price paths (e.g., Open -> Low -> High -> Close for bullish).
        if ($high == $low) { // Flat day, just pick a random time
            return $startOfDay->addSeconds(rand(0, $endOfDay->diffInSeconds($startOfDay)));
        }

        // Percentage of price range where targetPrice lies
        $priceRatio = ($targetPrice - $low) / ($high - $low);

        // Approximate time within the trading day (e.g., 9-5 = 8 hours)
        $tradingSeconds = $endOfDay->diffInSeconds($startOfDay);
        $secondsIntoDay = $tradingSeconds * $priceRatio;

        // Add some randomness around the calculated time
        $randomOffset = rand(- (int)($tradingSeconds * 0.1), (int)($tradingSeconds * 0.1)); // +/- 10% of trading day
        $secondsIntoDay = max(0, min($tradingSeconds, $secondsIntoDay + $randomOffset));

        return $startOfDay->addSeconds((int)$secondsIntoDay);
    }

}