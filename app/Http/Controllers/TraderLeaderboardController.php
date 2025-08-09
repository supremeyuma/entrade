<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trader;
use App\Http\Controllers\Controller;

class TraderLeaderboardController extends Controller
{
    public function publicLeaderboard()
    {
        $traders = Trader::with('trades')->orderByDesc('roi')
            ->limit(5)
            ->get();

        $now = \Carbon\Carbon::now();

        $tradersWithRoiData = $traders->map(function ($trader) use ($now) 
            {
                $now = \Carbon\Carbon::now();
                $roiData = [];

                //1W ROI
                $days = collect(range(0, 6))->map(fn($i) => $now->copy()->subDays($i))->reverse();
                $roiData['1W'] = $days->map(function ($day) use ($trader) {
                    return round($trader->trades
                        ->filter(fn($t) => \Carbon\Carbon::parse($t->exit_timestamp)->isSameDay($day))
                        ->avg('roi') ?? 0, 2);
                })->values()->all();

                 // 1M ROI (weekly data)
                $weeks = collect(range(0, 3))->map(fn($i) => $now->copy()->subWeeks($i))->reverse();
                $roiData['1M'] = $weeks->map(function ($week) use ($trader) {
                    $start = $week->copy()->startOfWeek();
                    $end = $week->copy()->endOfWeek();
                    return round($trader->trades
                        ->filter(fn($t) => \Carbon\Carbon::parse($t->exit_timestamp)->between($start, $end))
                        ->avg('roi') ?? 0, 2);
                })->values()->all();

                // 12M ROI (monthly data)
                $months = collect(range(0, 11))->map(fn($i) => $now->copy()->subMonths($i))->reverse();
                $roiData['12M'] = $months->map(function ($month) use ($trader) {
                    return round($trader->trades
                        ->filter(fn($t) => \Carbon\Carbon::parse($t->exit_timestamp)->format('Y-m') === $month->format('Y-m'))
                        ->avg('roi') ?? 0, 2);
                })->values()->all();
                   
                
        
        
            

                // Count subscribers
                $subscriberCount = $trader->subscriptions()->count(); // assumes Trader has 'subscribers()' relationship
                $average_roi = round($trader->trades->avg('roi') ?? 0, 2);
                
                $totalTrades = $trader->trades->count();
                $winningTrades = $trader->trades->filter(fn ($trade) =>$trade->roi > 0)->count();

                $winRate = round($winningTrades / $totalTrades * 100, 2);

                $trader->wwinRate = $winRate;
                $trader->roi = $average_roi;
                $trader->subscriberCount = $subscriberCount;
                $trader->roiData = $roiData;

                return $trader;

                
            }
        );

        //dd($tradersWithRoiData);

        return view('guests.leaderboard', compact('tradersWithRoiData'));
    }

    public function userLeaderboard(Request $request)
    {
        $query = Trader::query();

        if ($request->filled('min_roi')) {
            $query->where('roi', '>=', $request->input('min_roi'));
        }

        if ($request->filled('min_win_rate')) {
            $query->where('win_rate', '>=', $request->input('min_win_rate'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('trader_id', 'LIKE', "%{$search}%");
            });
        }

        $sort = $request->input('sort', 'roi');
        $direction = $request->input('direction', 'desc');
        $allowedSorts = ['roi', 'win_rate', 'subscribers', 'total_trades', 'avg_return_per_trade'];

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        }
        // Optional CSV Export
        if ($request->has('export')) {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="leaderboard.csv"',
            ];
        
            $callback = function () use ($query) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Name', 'Trader ID', 'ROI', 'Win Rate', 'Subscribers', 'Total Trades', 'Avg Return/Trade']);
        
                foreach ($query->get() as $trader) {
                    fputcsv($handle, [
                        $trader->name,
                        $trader->trader_id,
                        $trader->roi,
                        $trader->win_rate,
                        $trader->subscribers,
                        $trader->total_trades,
                        $trader->avg_return_per_trade,
                    ]);
                }
        
                fclose($handle);
            };
        
            return response()->stream($callback, 200, $headers);
        }
        //End of Optional CSV Export
        

        $traders = $query->paginate(20)->appends($request->query());

        return view('user.trade.leaderboard_user', compact('traders'));
    }
}
