<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Trader;
use Carbon\Carbon;

class TraderCard extends Component
{
    public $traderId;
    public $trader;

    // Chart data
    public $labels = [];
    public $roiData = [];

    public function mount($traderId)
    {
        $this->traderId = $traderId;
        $this->loadTrader();
    }

    public function loadTrader()
    {
        $trader = Trader::with('trades')->findOrFail($this->traderId);

        $now = Carbon::now();
        $roiData = [];

        // Labels for charts
        $labels = [
            '1W'  => collect(range(0, 6))->map(fn($i) => $now->copy()->subDays($i)->format('D'))->reverse()->values()->all(),
            '1M'  => collect(range(0, 3))->map(fn($i) => 'Week ' . ($i + 1))->values()->all(),
            '12M' => collect(range(0, 11))->map(fn($i) => $now->copy()->subMonths($i)->format('M'))->reverse()->values()->all(),
        ];

        // 1W ROI (daily)
        $days = collect(range(0, 6))->map(fn($i) => $now->copy()->subDays($i))->reverse();
        $roiData['1W'] = $days->map(function ($day) use ($trader) {
            return round($trader->trades
                ->filter(fn($t) => Carbon::parse($t->exit_timestamp)->isSameDay($day))
                ->avg('roi') ?? 0, 2);
        })->values()->all();

        // 1M ROI (weekly)
        $weeks = collect(range(0, 3))->map(fn($i) => $now->copy()->subWeeks($i))->reverse();
        $roiData['1M'] = $weeks->map(function ($week) use ($trader) {
            $start = $week->copy()->startOfWeek();
            $end   = $week->copy()->endOfWeek();
            return round($trader->trades
                ->filter(fn($t) => Carbon::parse($t->exit_timestamp)->between($start, $end))
                ->avg('roi') ?? 0, 2);
        })->values()->all();

        // 12M ROI (monthly)
        $months = collect(range(0, 11))->map(fn($i) => $now->copy()->subMonths($i))->reverse();
        $roiData['12M'] = $months->map(function ($month) use ($trader) {
            return round($trader->trades
                ->filter(fn($t) => Carbon::parse($t->exit_timestamp)->format('Y-m') === $month->format('Y-m'))
                ->avg('roi') ?? 0, 2);
        })->values()->all();

        // Extra stats
        $subscriberCount = $trader->subscriptions()->count();
        $average_roi     = round($trader->trades->avg('roi') ?? 0, 2);

        $totalTrades     = $trader->trades->count();
        $winningTrades   = $trader->trades->filter(fn ($trade) => $trade->roi > 0)->count();
        $winRate         = $totalTrades > 0 ? round($winningTrades / $totalTrades * 100, 2) : 0;

        // Assign props
        $trader->winRate          = $winRate;
        $trader->roi              = $average_roi;
        $trader->subscriberCount  = $subscriberCount;
        $trader->roiData          = $roiData;

        $this->trader  = $trader;
        $this->labels  = $labels;
        $this->roiData = $roiData;
    }

    public function refreshChart()
    {
        $this->loadTrader(); // reload data for real-time chart
    }

    public function render()
    {
        return view('livewire.trader-card', [
            'trader' => $this->trader
        ]);
    }
}
