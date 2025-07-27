<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trade;
use App\Models\Trader; // Assuming Trader model exists for validation
use App\Models\BotLog; // For logging simulation runs
use App\Services\MarketDataService; // Import the MarketDataService
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException; // For better error handling
use Illuminate\Support\Facades\Auth; // For admin_id in BotLog (if run authenticated)


class SimulateTrades extends Command
{
    protected $signature = 'trades:simulate
                            {trader_id : The ID of the trader}
                            {start_date : Format YYYY-MM-DD}
                            {end_date : Format YYYY-MM-DD}
                            {target_roi : Target ROI as percentage (e.g., 50)}
                            {market_type : forex|crypto|stocks|commodities}
                            {--symbols= : Comma-separated symbols (e.g., EURUSD,BTCUSD)}
                            {--strategy=intraday : Strategy type (scalp, intraday, swing)}'; // Default to intraday for broader applicability

    protected $description = 'Simulate trades for a trader over a date range to reach a target ROI using historical market data.';

    protected $marketDataService;

    /**
     * Constructor for dependency injection.
     * @param MarketDataService $marketDataService
     */
    public function __construct(MarketDataService $marketDataService)
    {
        parent::__construct();
        $this->marketDataService = $marketDataService;
    }

    protected function getStrategyConfig(string $strategy): array
    {
        return match ($strategy) {
            'scalp' => [
                'min_profit_pips' => 5, // Pips for forex, or percentage for others
                'max_profit_pips' => 20,
                'min_loss_pips' => 5,
                'max_loss_pips' => 15,
                'min_hold_minutes' => 2,
                'max_hold_minutes' => 15,
                'lot_min' => 0.01, // Adjusted for realism
                'lot_max' => 0.1,
                'ohlcv_interval' => '1min', // Smallest interval for scalping
            ],
            'swing' => [
                'min_profit_pips' => 100,
                'max_profit_pips' => 500,
                'min_loss_pips' => 50,
                'max_loss_pips' => 200,
                'min_hold_minutes' => 1440, // 1 day
                'max_hold_minutes' => 10080, // 7 days
                'lot_min' => 0.5,
                'lot_max' => 5.0,
                'ohlcv_interval' => 'daily', // Daily candles for swing
            ],
            default => [ // 'intraday'
                'min_profit_pips' => 20,
                'max_profit_pips' => 100,
                'min_loss_pips' => 10,
                'max_loss_pips' => 50,
                'min_hold_minutes' => 30,
                'max_hold_minutes' => 360, // 6 hours
                'lot_min' => 0.1,
                'lot_max' => 1.0,
                'ohlcv_interval' => '60min', // Hourly candles for intraday
            ],
        };
    }

    public function handle()
    {
        $traderId    = $this->argument('trader_id');
        $startDate   = Carbon::parse($this->argument('start_date'));
        $endDate     = Carbon::parse($this->argument('end_date'));
        $roiTarget   = (float) $this->argument('target_roi');
        $marketType  = strtolower($this->argument('market_type'));
        $symbolsInput = $this->option('symbols');
        $strategy    = strtolower($this->option('strategy')) ?: 'intraday';

        // 1. Basic Argument Validation
        try {
            $this->validateArguments([
                'trader_id' => $traderId,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'target_roi' => $roiTarget,
                'market_type' => $marketType,
                'strategy' => $strategy,
            ]);
        } catch (ValidationException $e) {
            foreach ($e->errors() as $field => $messages) {
                $this->error("Validation Error for {$field}: " . implode(', ', $messages));
            }
            return Command::FAILURE;
        }

        // Check if trader exists
        if (!Trader::find($traderId)) {
            $this->error("Trader with ID {$traderId} not found.");
            return Command::FAILURE;
        }

        // Get symbols based on input or default
        $defaultSymbols = $this->getSampleSymbols($marketType);
        $symbols = $symbolsInput
            ? array_filter(array_map('trim', explode(',', $symbolsInput)), fn($s) => in_array($s, $defaultSymbols))
            : $defaultSymbols;

        if (empty($symbols)) {
            $this->error("❌ No valid symbols found for market type '{$marketType}'. Please provide --symbols option or check default symbols.");
            return Command::FAILURE;
        }

        $strategyConfig = $this->getStrategyConfig($strategy);
        $ohlcvInterval = $strategyConfig['ohlcv_interval']; // Use interval from strategy config

        $this->info("Simulating trades for trader: {$traderId} from {$startDate->toDateString()} to {$endDate->toDateString()} on {$marketType} targeting ROI {$roiTarget}% with {$strategy} strategy.");

        $batchId = Str::uuid()->toString();
        $this->info("Generated Batch ID: {$batchId}");

        // Create initial BotLog entry
        $botLog = BotLog::create([
            'admin_id'   => Auth::check() ? Auth::id() : null, // Get authenticated admin ID if available
            'trader_id'  => $traderId,
            'market'     => $marketType,
            'roi'        => $roiTarget,
            'strategy'   => $strategy,
            'status'     => 'running',
            'batch_id'   => $batchId,
            'input_data' => json_encode([
                'trader_id'       => $traderId,
                'start_date'      => $startDate->toDateString(),
                'end_date'        => $endDate->toDateString(),
                'target_roi'      => $roiTarget,
                'market_type'     => $marketType,
                'symbols'         => $symbols,
                'strategy'        => $strategy,
                'strategy_config' => $strategyConfig,
            ]),
        ]);

        $simulatedTrades = [];
        $currentROI = 0;
        $tradeCount = 0;
        $initialBalance = 1000; // Starting balance for ROI calculation
        $minTrades = 3; // Minimum trades to ensure some data
        $maxTrades = 100; // Max trades to prevent infinite loops, can be higher for real data

        // Fetch OHLCV data for all symbols upfront
        $allOhlcvData = [];
        $this->info("Fetching historical data for selected symbols...");
        $this->withProgressBar($symbols, function ($symbol) use (&$allOhlcvData, $ohlcvInterval, $startDate, $endDate) {
            $ohlcv = $this->marketDataService->getOhlcvData($symbol, $ohlcvInterval, 'full');
            if ($ohlcv) {
                // Filter OHLCV data within the specified date range
                $filteredOhlcv = array_filter($ohlcv, function($candle) use ($startDate, $endDate) {
                    return $candle['timestamp']->between($startDate->startOfDay(), $endDate->endOfDay());
                });
                if (!empty($filteredOhlcv)) {
                    $allOhlcvData[$symbol] = array_values($filteredOhlcv); // Re-index array
                } else {
                    $this->warn("No OHLCV data for {$symbol} within date range '{$startDate->toDateString()}' to '{$endDate->toDateString()}'.");
                }
            } else {
                $this->warn("Failed to fetch OHLCV data for {$symbol} with interval '{$ohlcvInterval}'.");
            }
        });

        if (empty($allOhlcvData)) {
            $this->error("❌ No historical market data available for any of the selected symbols within the date range. Aborting simulation.");
            $botLog->update([
                'errors' => json_encode(['No historical market data available for simulation.']),
                'summary' => 'Simulation failed: No market data.',
                'status' => 'failed',
            ]);
            return Command::FAILURE;
        }

        // Loop to simulate trades based on fetched OHLCV data
        $this->info("Simulating trades based on historical data...");
        $attempts = 0;
        $maxSimulationAttempts = $maxTrades * 5; // Prevent infinite loop if ROI target is hard to hit

        while (($currentROI < $roiTarget || $tradeCount < $minTrades) && $tradeCount < $maxTrades && $attempts < $maxSimulationAttempts) {
            $attempts++;

            // Pick a random symbol for this trade from those with available data
            $availableSymbols = array_keys($allOhlcvData);
            if (empty($availableSymbols)) {
                $this->warn("No symbols with available data left to simulate trades.");
                break;
            }
            $pair = $availableSymbols[array_rand($availableSymbols)];
            $symbolOhlcv = $allOhlcvData[$pair];

            // Pick a random candle from the available OHLCV data for this symbol
            if (empty($symbolOhlcv)) {
                continue; // Skip if no candles available for the chosen symbol
            }
            $candle = $symbolOhlcv[array_rand($symbolOhlcv)];

            // Simulate trade outcome (win/loss)
            $isLoss = (rand(1, 10) <= 3); // 30% chance of loss for realism (Phase 5)

            // Calculate profit/loss in pips based on strategy config
            $profitPips = $isLoss
                ? -rand($strategyConfig['min_loss_pips'], $strategyConfig['max_loss_pips'])
                : rand($strategyConfig['min_profit_pips'], $strategyConfig['max_profit_pips']);

            // Simple price calculation based on pips (assuming 1 pip = 0.0001 for forex, adjust for crypto/stocks)
            $pipValue = 0.0001; // Default for forex. Needs to be dynamic for other markets.
            if ($marketType === 'crypto') $pipValue = 0.01; // Example for crypto
            if ($marketType === 'stocks') $pipValue = 0.1; // Example for stocks

            $entryPrice = $candle['close']; // Assume entry at candle close for simplicity
            $exitPrice = $entryPrice + ($profitPips * $pipValue);

            // Ensure prices are positive and reasonable
            $entryPrice = max(0.0001, $entryPrice);
            $exitPrice = max(0.0001, $exitPrice);

            // Calculate profit in currency based on lot size
            $lotSize = round(mt_rand($strategyConfig['lot_min'] * 100, $strategyConfig['lot_max'] * 100) / 100, 2);
            $profitCurrency = ($exitPrice - $entryPrice) * $lotSize * 10000; // Simplified: 10000 for forex standard lot equivalent

            // Calculate profit percentage relative to initial balance or risked capital
            // For simplicity, let's use profit percentage relative to entry price for now
            $profitPercentage = ($profitCurrency / ($entryPrice * $lotSize * 10000)) * 100; // Simplified ROI per trade

            // Adjust profit percentage if it's a loss to ensure it's negative
            if ($isLoss && $profitPercentage > 0) $profitPercentage *= -1;
            if (!$isLoss && $profitPercentage < 0) $profitPercentage *= -1;


            // Generate opened_at and closed_at within the candle's timeframe
            $openedAt = $candle['timestamp']->copy()->addMinutes(rand(0, $strategyConfig['ohlcv_interval'] === '1min' ? 0 : 59)); // Open within candle
            $holdMinutes = rand($strategyConfig['min_hold_minutes'], $strategyConfig['max_hold_minutes']);
            $closedAt = $openedAt->copy()->addMinutes($holdMinutes);

            // Ensure closed_at is within the overall simulation range
            if ($closedAt->greaterThan($endDate)) {
                $closedAt = $endDate;
                if ($closedAt->lessThanOrEqualTo($openedAt)) {
                    $openedAt = $closedAt->copy()->subMinutes(rand(1, $holdMinutes)); // Adjust opened_at if closed_at is too early
                    if ($openedAt->lessThan($startDate)) {
                        $openedAt = $startDate; // Cap at start date
                    }
                }
            }


            $trades[] = [
                'trader_id'         => $traderId,
                'symbol'            => $pair,
                'market'            => $marketType,
                'entry_price'       => round($entryPrice, 5),
                'exit_price'        => round($exitPrice, 5),
                'lot_size'          => $lotSize,
                //'profit'            => round($profitCurrency, 2), // Monetary profit
                'profit_percentage' => round($profitPercentage, 2), // Percentage profit
                'opened_at'         => $openedAt,
                'closed_at'         => $closedAt,
                'status'            => 'closed', // All simulated trades are closed
                'batch_id'          => $batchId,
                'type'              => ($profitPercentage > 0) ? 'buy' : 'sell', // Simplified type
            ];

            $currentROI += $profitPercentage; // Accumulate ROI percentage
            $tradeCount++;

            if ($tradeCount >= $maxTrades) break;
        }

        // Final insertion and BotLog update
        if (!empty($trades)) {
            Trade::insert($trades); // Use insert for performance
            $botLog->update([
                'output_data' => json_encode([
                    'trade_count' => count($trades),
                    'final_roi' => round($currentROI, 2),
                    'total_profit_currency' => array_sum(array_column($trades, 'profit')),
                ]),
                'summary' => 'Simulation completed: ' . count($trades) . ' trades generated with final ROI ' . round($currentROI, 2) . '%',
                'status' => 'completed',
            ]);
            $this->info("✅ Completed: Inserted " . count($trades) . " trades.");
            $this->info("Final simulated ROI: " . round($currentROI, 2) . "% (Target: {$roiTarget}%)");
            return Command::SUCCESS;
        } else {
            $botLog->update([
                'errors' => json_encode(['No trades were generated or market data was insufficient.']),
                'summary' => 'Simulation failed: No trades generated or insufficient market data.',
                'status' => 'failed',
            ]);
            $this->warn("⚠️ No trades were generated.");
            return Command::FAILURE;
        }
    }

    /**
     * Internal validation for arguments.
     * @throws ValidationException
     */
    protected function validateArguments(array $arguments)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($arguments, [
            'trader_id' => 'required|exists:traders,id',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date',
            'target_roi' => 'required|numeric|min:0',
            'market_type' => 'required|in:forex,crypto,stocks,commodities',
            'strategy' => 'required|in:scalp,intraday,swing',
        ]);

        $validator->validate();
    }

    /**
     * Provides default symbols based on market type.
     * @param string $marketType
     * @return array
     */
    protected function getSampleSymbols(string $marketType): array
    {
        return match (strtolower($marketType)) {
            'forex' => ['EURUSD', 'GBPUSD', 'USDJPY', 'AUDUSD'],
            'crypto' => ['BTCUSD', 'ETHUSD', 'SOLUSD', 'XRPUSD'],
            'stocks' => ['AAPL', 'MSFT', 'TSLA', 'GOOGL'],
            'commodities' => ['XAUUSD', 'XAGUSD', 'WTIUSD'], // Gold, Silver, Oil
            default => [],
        };
    }
}