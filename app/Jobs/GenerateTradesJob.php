<?php

namespace App\Jobs;

use App\Models\Trade;
use App\Models\Trader;
use App\Models\BotLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
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
    public $timeframe;
    public $riskPerTrade;
    public $desiredWinRate;
    public $maxTrades;

    public function __construct($traderId, $market, $roi, $fromDate, $toDate, $timeframe = '1d', $riskPerTrade = 1, $desiredWinRate = 60, $maxTrades = null)
    {
        $this->traderId = $traderId;
        $this->market = $market;
        $this->roi = $roi;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->timeframe = $timeframe;
        $this->riskPerTrade = $riskPerTrade;
        $this->desiredWinRate = $desiredWinRate;
        $this->maxTrades = $maxTrades;
    }

    public function handle()
    {
        $log = BotLog::create([
            'admin_id'   => Auth::id(),
            'trader_id'  => $this->traderId,
            'market'     => $this->market,
            'roi'        => $this->roi,
            'strategy'   => 'Historical ROI Simulation',
            'input_data' => json_encode([
                'roi_target'      => $this->roi,
                'market'          => $this->market,
                'timeframe'       => $this->timeframe,
                'risk_per_trade'  => $this->riskPerTrade,
                'desired_winrate' => $this->desiredWinRate,
                'max_trades'      => $this->maxTrades,
                'from'            => $this->fromDate,
                'to'              => $this->toDate,
            ]),
        ]);

        try {
            $simulatedTrades = $this->simulateTrades();

            foreach ($simulatedTrades as $trade) {
                Trade::create([
                    'trader_id'   => $this->traderId,
                    'pair'        => $trade['pair'],
                    'type'        => $trade['type'],
                    'entry_price' => $trade['entry_price'],
                    'exit_price'  => $trade['exit_price'],
                    'profit'      => $trade['profit'],
                    'opened_at'   => Carbon::parse($trade['opened_at']),
                    'closed_at'   => Carbon::parse($trade['closed_at']),
                    'source'      => 'bot',
                    'meta'        => json_encode([
                        'roi_target'      => $this->roi,
                        'timeframe'       => $this->timeframe,
                        'risk_per_trade'  => $this->riskPerTrade,
                        'desired_winrate' => $this->desiredWinRate,
                        'strategy'        => 'Historical ROI Simulation',
                    ]),
                ]);
            }

            $log->update([
                'output_data' => json_encode([
                    'trade_count' => count($simulatedTrades),
                    'trades' => $simulatedTrades,
                ]),
                'summary' => count($simulatedTrades) . ' trades generated successfully.',
            ]);

        } catch (\Exception $e) {
            $log->update([
                'errors' => json_encode([$e->getMessage()]),
                'summary' => 'Failed to generate trades: ' . $e->getMessage(),
            ]);
        }
    }

    private function simulateTrades(): array
    {
        $trades = [];
        $start = Carbon::parse($this->fromDate);
        $end = Carbon::parse($this->toDate);
        $interval = match ($this->timeframe) {
            '1h' => 60,
            '4h' => 240,
            '1d' => 1440,
        };

        $totalMinutes = $start->diffInMinutes($end);
        $maxPossibleTrades = floor($totalMinutes / $interval);
        $targetTradeCount = $this->maxTrades ?? min(100, $maxPossibleTrades);

        $winCount = floor($targetTradeCount * ($this->desiredWinRate / 100));
        $lossCount = $targetTradeCount - $winCount;

        for ($i = 0; $i < $targetTradeCount; $i++) {
            $win = $i < $winCount;
            $entry = $start->copy()->addMinutes($i * $interval);
            $exit = $entry->copy()->addMinutes($interval);
            $profit = $win
                ? round(($this->riskPerTrade / 100) * rand(120, 200), 2) // win trades
                : round(($this->riskPerTrade / 100) * -rand(80, 100), 2); // losing trades

            $trades[] = [
                'pair' => $this->randomSymbol($this->market),
                'type' => fake()->randomElement(['buy', 'sell']),
                'entry_price' => fake()->randomFloat(2, 20, 500),
                'exit_price'  => fake()->randomFloat(2, 20, 500),
                'profit' => $profit,
                'opened_at' => $entry->toDateTimeString(),
                'closed_at' => $exit->toDateTimeString(),
            ];
        }

        return $trades;
    }

    private function randomSymbol($market): string
    {
        return fake()->randomElement(match (strtolower($market)) {
            'forex' => ['EUR/USD', 'GBP/USD', 'USD/JPY', 'AUD/USD'],
            'crypto' => ['BTC/USDT', 'ETH/USDT', 'SOL/USDT', 'XRP/USDT'],
            'stocks' => ['AAPL', 'MSFT', 'TSLA', 'GOOGL'],
            'commodities' => ['XAU/USD', 'XAG/USD', 'WTI/USD'],
            default => ['EUR/USD'],
        });
    }
}
