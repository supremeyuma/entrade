<?php

namespace App\Jobs;

use App\Models\Trade;
use App\Models\TradeBotConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateHistoricalTradesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $config;

    public function __construct(TradeBotConfig $config)
    {
        $this->config = $config;
    }

    public function handle()
    {
        $this->config->appendLog("🔁 Starting trade generation for config ID: {$this->config->id}");

        // Example loop to simulate trades
        $symbols = $this->config->trading_pairs;
        $roi = 0;
        $trades = [];

        foreach ($symbols as $symbol) {
            $this->config->appendLog("📈 Simulating trades for $symbol...");

            // Simulate trades based on timeframe
            for ($i = 0; $i < 5; $i++) {
                $trade = [
                    'symbol' => $symbol,
                    'roi' => rand(1, 10), // fake ROI
                    'entry_price' => rand(100, 200),
                    'exit_price' => rand(200, 300),
                    'timestamp' => now()->subDays(rand(0, 30)),
                    'source' => 'bot',
                    'trader_id' => $this->config->assign_to,
                    'market' => $this->config->markets[0],
                ];
                $roi += $trade['roi'];
                $trades[] = $trade;
            }
        }

        foreach ($trades as $trade) {
            Trade::create($trade);
        }

        $avgRoi = round($roi / count($trades), 2);
        $this->config->appendLog("✅ Finished simulating " . count($trades) . " trades.");
        $this->config->appendLog("📊 Average ROI: {$avgRoi}%");
    }
}
