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
                            {--symbols= : Comma-separated symbols (e.g., EURUSD,BTCUSD)}';

    protected $description = 'Simulate trades for a trader over a date range to reach a target ROI';

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


        $balance = 1000;
        $currentROI = 0;
        $totalProfit = 0;
        $batchId = Str::uuid();

        while ($currentROI < $roiTarget) {
            $pair = $symbols[array_rand($symbols)];
            $entry = rand(100000, 200000) / 100000; // Random price like 1.2345
            $profit = rand(50, 200); // Random profit per trade
            $lotSize = rand(5, 15) / 10; // 0.5 - 1.5
            $exit = $entry + ($profit / 10000); // Rough simulation

            $openedAt = $start->copy()->addMinutes(rand(0, $end->diffInMinutes($start)));
            $closedAt = $openedAt->copy()->addMinutes(rand(5, 240));

            Trade::create([
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
            ]);

            $totalProfit += $profit;
            $currentROI = ($totalProfit / $balance) * 100;
        }

        $this->info("✅ Completed: Inserted trades to achieve ROI of $currentROI% (target was $roiTarget%)");
        $this->info("🆔 Batch ID: $batchId");
    }

    protected function getSampleSymbols($type)
    {
        return match ($type) {
            'forex' => ['EURUSD', 'GBPJPY', 'USDJPY', 'AUDUSD'],
            'crypto' => ['BTCUSD', 'ETHUSD', 'SOLUSD', 'XRPUSD'],
            'stocks' => ['AAPL', 'TSLA', 'MSFT', 'AMZN'],
            default => ['EURUSD'],
        };
    }
}

