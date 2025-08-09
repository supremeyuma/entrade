<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TradeOutcome;
use App\Models\TradeHistory;
use App\Models\Trade;
use App\Models\Trader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserTradeController extends Controller
{
    //

    public function showOutcome($id)
    {
        

        $user = auth()->user();
        $trader_id = $id;
        $userSubscription = $user->subscriptions()->where('trader_id', $trader_id)->first();
        $trader = Trader::where('id', $id)->first();
        //dd( $userSubscription);
        
        $histories = $user->tradeHistories()->where('trader_id', $trader_id)->orderBy('created_at', 'desc')->get();
        // Cumulative ROI (sum of percentage_change for this trader)
        $cumulativeRoi = Trade::where('trader_id', $trader_id)->sum('roi');

        $lastHistory = $user->tradeHistories()->where('trader_id', $trader_id)->latest('trade_id')->first();

        $newBalance = $lastHistory->new_trade_balance;

        $percentageChange = $histories->sum('roi');
        $gainLoss = $histories->sum('amount_returned') - $histories->sum('amount_invested');

        // How many days subscribed
        $daysSubscribed = $userSubscription
            ? now()->diffInDays($userSubscription->created_at)
            : null;

        // Last 3 trade outcomes (excluding current one)
        $recentOutcomes = TradeHistory::where('trader_id', $trader_id)
            //->where('id', '<>', $tradeOutcome->id)
            ->latest()
            ->take(3)
            ->get();

    

        return view('user.trade.outcome_show', compact(
            //'tradeOutcome',
            'userSubscription',
            'cumulativeRoi',
            'daysSubscribed',
            'recentOutcomes',
            'trader',
            'percentageChange',
            'gainLoss',
            'lastHistory',
            'newBalance',
            'histories',
        ));
    }

    /*public function show(Trader $trader)
    {
        return view('traders.profile', compact('trader'));
    }*/

    public function trades(Trader $trader)
    {
        $trades = $trader->trades()->latest()->paginate(20);
        return view('guests.trader-trades', compact('trader', 'trades'));
    }

    // Show user leaderboard page
    public function leaderboard(Request $request)
    {
        $query = Trader::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('trader_id', 'like', "%{$search}%");
        }

        if ($minRoi = $request->input('min_roi')) {
            $query->where('roi', '>=', $minRoi);
        }

        if ($minWinRate = $request->input('min_win_rate')) {
            $query->where('win_rate', '>=', $minWinRate);
        }

        // Sorting
        $sort = $request->input('sort', 'roi');
        $direction = $request->input('direction', 'desc');

        if (in_array($sort, ['roi', 'win_rate', 'subscriptions_count', 'total_trades', 'avg_return_per_trade'])) {
            $query->orderBy($sort, $direction);
        }

        // Load counts for subscribers and trades
        $query->withCount(['subscriptions', 'trades']);

        // Pagination
        $traders = $query->paginate(15)->withQueryString();

        $user = Auth::user();

        // Monthly ROI (e.g. Jan-Dec)
         $range = request('range', '12m'); // Default to 12 months
        $now = \Carbon\Carbon::now();

        $labels = [];
        $roiSeries = [];

        if ($range === '1w') {
            $days = collect(range(0, 6))->map(fn($i) => $now->copy()->subDays($i))->reverse();

            $labels = $days->map(fn($d) => $d->format('D d M'))->values()->all();
            $roiData = $days->map(function ($day) use ($trader) {
                return round($trader->trades
                    ->filter(fn($t) => \Carbon\Carbon::parse($t->exit_timestamp)->isSameDay($day))
                    ->avg('roi') ?? 0, 2);
            });

        } else {
            // Interpret range (e.g. "3m", "6m", "12m", "24m")
            $months = match ($range) {
                '1m' => 1,
                '6m' => 6,
                '24m' => 24,
                default => 12
            };

            $monthDates = collect(range(0, $months - 1))
                ->map(fn($i) => $now->copy()->subMonths($i))
                ->reverse();

            $labels = $monthDates->map(fn($d) => $d->format('M Y'))->values()->all();
            $roiSeries = $monthDates->map(function ($month) use ($trader) {
                $avgRoi = $trader->trades
                    ->filter(fn($t) => \Carbon\Carbon::parse($t->exit_timestamp)->format('Y-m') === $month->format('Y-m'))
                    ->avg('roi');

                return round($avgRoi ?? 0, 2);
            }) ->values()->all();
        }
        

        return view('user.trade.leaderboard_user', compact('traders', 'user', 'roiSeries', 'labels'));
    }

    // Show trader profile page for users
    public function profile(Trader $trader)
    {
        $user = Auth::user();

        // Example ROI history for chart (you'll replace with real data)
        $roiHistory = $trader->tradeOutcomes()
            ->orderBy('created_at')
            ->get(['created_at', 'percentage_change'])
            ->map(function($item) {
                return [
                    'date' => $item->created_at->format('Y-m-d'),
                    'roi' => round($item->percentage_change, 2),
                ];
            });

        // Append to trader model for view
        $trader->roiHistory = $roiHistory;

        //New conline for guests blade
        $recentTrades = $trader->trades()->latest()->take(5)->get();

        //dd($trader);
        return view('user.trade.profile', compact('trader', 'user', 'recentTrades'));
    }

    // Add trader to comparison list (session-based)
    public function addToCompare(Request $request, Trader $trader)
    {
        $compare = Session::get('trader_compare', []);

        if (count($compare) >= 5) {
            return redirect()->back()->with('error', 'You can compare up to 5 traders only.');
        }

        if (!in_array($trader->id, $compare)) {
            $compare[] = $trader->id;
            Session::put('trader_compare', $compare);
        }

        return redirect()->back()->with('success', 'Trader added to comparison.');
    }

    // Show comparison page
    public function compare()
    {
        $compareIds = Session::get('trader_compare', []);

        $traders = Trader::whereIn('id', $compareIds)->get();

        return view('user.trade.compare', compact('traders'));
    }


     public function show(Trader $trader)
    {
        $trader->load('trades');
            // Paginate trades
        $trades = $trader->trades()->latest()->paginate(20);

        // Monthly ROI (e.g. Jan-Dec)
         $range = request('range', '12m'); // Default to 12 months
        $now = \Carbon\Carbon::now();

        $labels = [];
        $roiData = [];

        if ($range === '1w') {
            $days = collect(range(0, 6))->map(fn($i) => $now->copy()->subDays($i))->reverse();

            $labels = $days->map(fn($d) => $d->format('D d M'))->values()->all();
            $roiData = $days->map(function ($day) use ($trader) {
                return round($trader->trades
                    ->filter(fn($t) => \Carbon\Carbon::parse($t->exit_timestamp)->isSameDay($day))
                    ->avg('roi') ?? 0, 2);
            });

        } else {
            // Interpret range (e.g. "3m", "6m", "12m", "24m")
            $months = match ($range) {
                '3m' => 3,
                '6m' => 6,
                '24m' => 24,
                default => 12
            };

            $monthDates = collect(range(0, $months - 1))
                ->map(fn($i) => $now->copy()->subMonths($i))
                ->reverse();

            $labels = $monthDates->map(fn($d) => $d->format('M Y'))->values()->all();
            $roiData = $monthDates->map(function ($month) use ($trader) {
                $avgRoi = $trader->trades
                    ->filter(fn($t) => \Carbon\Carbon::parse($t->exit_timestamp)->format('Y-m') === $month->format('Y-m'))
                    ->avg('roi');

                return round($avgRoi ?? 0, 2);
            }) ->values()->all();
        }
        

        // Count subscribers
        $subscriberCount = $trader->subscriptions()->count(); // assumes Trader has 'subscribers()' relationship
        $average_roi = round($trader->trades->avg('roi') ?? 0, 2);
        
        $totalTrades = $trader->trades->count();
        $winningTrades = $trader->trades->filter(fn ($trade) =>$trade->roi > 0)->count();

        $winRate = round($winningTrades / $totalTrades * 100, 2);
    return view('traders.profile', compact('trader', 'trades', 'roiData', 'labels', 'subscriberCount', 'average_roi', 'winRate'));

    }


     public function traderCard(Trader $trader)
        {
            $trader->load('trades');
                // Paginate trades
            $trades = $trader->trades()->latest()->paginate(20);

            // Monthly ROI (e.g. Jan-Dec)
            $range = request('range', '12m'); // Default to 12 months
            $now = \Carbon\Carbon::now();

            $labels = [];
            $roiData = [];

            if ($range === '1w') {
                $days = collect(range(0, 6))->map(fn($i) => $now->copy()->subDays($i))->reverse();

                $labels = $days->map(fn($d) => $d->format('D d M'))->values()->all();
                $roiData = $days->map(function ($day) use ($trader) {
                    return round($trader->trades
                        ->filter(fn($t) => \Carbon\Carbon::parse($t->exit_timestamp)->isSameDay($day))
                        ->avg('roi') ?? 0, 2);
                });

            } else {
                // Interpret range (e.g. "3m", "6m", "12m", "24m")
                $months = match ($range) {
                    '3m' => 3,
                    '6m' => 6,
                    '24m' => 24,
                    default => 12
                };

                $monthDates = collect(range(0, $months - 1))
                    ->map(fn($i) => $now->copy()->subMonths($i))
                    ->reverse();

                $labels = $monthDates->map(fn($d) => $d->format('M Y'))->values()->all();
                $roiData = $monthDates->map(function ($month) use ($trader) {
                    $avgRoi = $trader->trades
                        ->filter(fn($t) => \Carbon\Carbon::parse($t->exit_timestamp)->format('Y-m') === $month->format('Y-m'))
                        ->avg('roi');

                    return round($avgRoi ?? 0, 2);
                }) ->values()->all();
            }
            

            // Count subscribers
            $subscriberCount = $trader->subscriptions()->count(); // assumes Trader has 'subscribers()' relationship
            $average_roi = round($trader->trades->avg('roi') ?? 0, 2);
            
            $totalTrades = $trader->trades->count();
            $winningTrades = $trader->trades->filter(fn ($trade) =>$trade->roi > 0)->count();

            $winRate = round($winningTrades / $totalTrades * 100, 2);
        return view('admin.traders.show', compact('trader', 'trades', 'roiData', 'labels', 'subscriberCount', 'average_roi', 'winRate'));

        }

}
