<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trade;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SimulateTrades extends Command
{
    protected $signature = 'trades:simulate
                            {trader_id : The ID of the trader}
                            {start_date : Format YYYY-MM-DD}
                            {end_date : Format YYYY-MM-DD}
                            {target_roi : Target ROI as percentage (e.g., 50)}
                            {market_type : forex|crypto|stocks}
                            {--symbols= : Comma-separated symbols (e.g., EURUSD,BTCUSD)}
                            {--strategy=scalp : Strategy type (scalp, intraday, swing)}';

    protected $description = 'Simulate trades for a trader over a date range to reach a target ROI';

    protected function getStrategyConfig(string $strategy): array
    {
        return match ($strategy) {
            'scalp' => [
                'min_profit' => 20,
                'max_profit' => 70,
                'min_loss' => 20,
                'max_loss' => 50,
                'min_hold_minutes' => 2,
                'max_hold_minutes' => 15,
                'lot_min' => 0.1,
                'lot_max' => 0.5,
            ],
            'swing' => [
                'min_profit' => 150,
                'max_profit' => 300,
                'min_loss' => 80,
                'max_loss' => 150,
                'min_hold_minutes' => 360,
                'max_hold_minutes' => 4320,
                'lot_min' => 1.0,
                'lot_max' => 2.5,
            ],
            default => [
                'min_profit' => 60,
                'max_profit' => 150,
                'min_loss' => 40,
                'max_loss' => 80,
                'min_hold_minutes' => 30,
                'max_hold_minutes' => 240,
                'lot_min' => 0.3,
                'lot_max' => 1.0,
            ],
        };
    }

    public function handle()
    {
        $traderId = $this->argument('trader_id');
        $start = Carbon::parse($this->argument('start_date'));
        $end = Carbon::parse($this->argument('end_date'));
        $roiTarget = (float) $this->argument('target_roi');
        $marketType = strtolower($this->argument('market_type'));

        $this->info("Simulating trades for trader: $traderId from $start to $end on $marketType targeting ROI $roiTarget%");

        $defaultSymbols = $this->getSampleSymbols($marketType);
        $symbols = $this->option('symbols')
            ? array_filter(array_map('trim', explode(',', $this->option('symbols'))), fn($s) => in_array($s, $defaultSymbols))
            : $defaultSymbols;

        if (empty($symbols)) {
            $this->error("❌ No valid symbols found.");
            return 1;
        }

        $strategy = strtolower($this->option('strategy')) ?: 'intraday';

        if (!in_array($strategy, ['scalp', 'intraday', 'swing'])) {
            $this->error("❌ Invalid strategy: $strategy. Must be one of: scalp, intraday, swing");
            return 1;
        }

        $config = $this->getStrategyConfig($strategy);

        $balance = 1000;
        $currentROI = 0;
        $totalProfit = 0;
        $batchId = Str::uuid();

        $minTrades = 3;
        $maxTrades = 7;
        $tradeCount = 0;
        $trades = [];

        while ($currentROI < $roiTarget || $tradeCount < $minTrades) {
            $pair = $symbols[array_rand($symbols)];

            // Add randomness to entry price to avoid robotic patterns
            $basePrice = rand(100000, 200000) / 100000;
            $entry = round($basePrice + rand(-30, 30) / 100000, 5);

            // Base lot size
            $lotSize = round(mt_rand($config['lot_min'] * 100, $config['lot_max'] * 100) / 100, 2);

            // Random loss logic
            $isLoss = $tradeCount >= 1 && rand(1, 10) <= 3;

            if ($isLoss) {
                $lotSize = round($lotSize * 1.1, 2); // Slightly higher on loss
                $profit = -rand($config['min_loss'], $config['max_loss']);
                $exit = round($entry - abs($profit / 10000), 5);
            } else {
                $profit = rand($config['min_profit'], $config['max_profit']);
                $exit = round($entry + ($profit / 10000), 5);
            }

            // Generate time within range
            $openedAt = $start->copy()->addMinutes(rand(0, $end->diffInMinutes($start)));
            $holdMinutes = rand($config['min_hold_minutes'], $config['max_hold_minutes']);
            $closedAt = $openedAt->copy()->addMinutes($holdMinutes);

            $trades[] = [
                'trader_id' => $traderId,
                'pair' => $pair,
                'type' => 'buy',
                'entry_price' => $entry,
                'exit_price' => $exit,
                'lot_size' => $lotSize,
                'profit' => $profit,
                'opened_at' => $openedAt,
                'closed_at' => $closedAt,
                'status' => 'closed',
                'batch_id' => $batchId,
            ];

            $totalProfit += $profit;
            $currentROI = ($totalProfit / $balance) * 100;
            $tradeCount++;

            if ($tradeCount >= $maxTrades) break;
        }

        foreach ($trades as $trade) {
            Trade::create($trade);
        }

        $this->info("✅ Completed: Inserted trades to achieve ROI of $currentROI% (target was $roiTarget%)");
        $this->info("🆔 Batch ID: $batchId");
    }

    protected function getSampleSymbols($type)
    {
        return match ($type) {
            'forex' => ['EURUSD', 'GBPJPY', 'USDJPY', 'AUDUSD'],
            'crypto' => ['BTCUSD', 'ETHUSD', 'SOLUSD', 'XRPUSD'],
            'stocks' => ['AAPL', 'TSLA', 'MSFT', 'AMZN', 'GOOGL'],
            'commodities' => ['XAU/USD', 'XAG/USD', 'WTI/USD'],
            default => ['EURUSD'],
        };
    }
}
