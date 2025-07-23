<?php

namespace App\Jobs;

use App\Models\Trade;
use Carbon\Carbon;
use App\Models\Trader;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateTradesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $traderId;
    public $market;
    public $roi;
    public $fromDate;
    public $toDate;

    /**
     * Create a new job instance.
     */
    public function __construct($traderId, $market, $roi, $fromDate, $toDate)
    {
        $this->traderId = $traderId;
        $this->market = $market;
        $this->roi = $roi;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($simulatedTrades as $trade) {
            Trade::create([
                'trader_id'    => $this->traderId,
                'pair'         => $trade['pair'],
                'type'         => $trade['type'],
                'entry_price'  => $trade['entry_price'],
                'exit_price'   => $trade['exit_price'],
                'profit'       => $trade['profit'],
                'opened_at'    => Carbon::parse($trade['opened_at']),
                'closed_at'    => Carbon::parse($trade['closed_at']),
                'source'       => 'bot',
                'meta'         => json_encode([
                    'roi_target' => $this->roi,
                    'market'     => $this->market,
                    'strategy'   => $trade['strategy'] ?? 'ROI Simulation',
                ]),
            ]);
        }    
    }

    /**
     * Returns a random symbol based on market type.
     */
    private function randomSymbol($market): string
    {
        $pairs = match (strtolower($market)) {
            'forex' => ['EUR/USD', 'GBP/USD', 'USD/JPY', 'AUD/USD'],
            'crypto' => ['BTC/USDT', 'ETH/USDT', 'SOL/USDT', 'XRP/USDT'],
            'stocks' => ['AAPL', 'MSFT', 'TSLA', 'GOOGL'],
            'commodities' => ['XAU/USD', 'XAG/USD', 'WTI/USD'],
            default => ['EUR/USD'],
        };

        return fake()->randomElement($pairs);
    }
}
