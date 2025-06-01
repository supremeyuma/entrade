<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TradeOutcome;
use App\Models\Trader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserTradeController extends Controller
{
    //

    public function showOutcome($id)
    {
        $tradeOutcome = TradeOutcome::with('trader')->findOrFail($id);

        $user = auth()->user();
        $userSubscription = $user->subscriptions()->where('trader_id', $tradeOutcome->trader_id)->first();

        // Cumulative ROI (sum of percentage_change for this trader)
        $cumulativeRoi = TradeOutcome::where('trader_id', $tradeOutcome->trader_id)->sum('percentage_change');

        // How many days subscribed
        $daysSubscribed = $userSubscription
            ? now()->diffInDays($userSubscription->created_at)
            : null;

        // Last 3 trade outcomes (excluding current one)
        $recentOutcomes = TradeOutcome::where('trader_id', $tradeOutcome->trader_id)
            ->where('id', '<>', $tradeOutcome->id)
            ->latest()
            ->take(3)
            ->get();

        return view('user.trade.outcome_show', compact(
            'tradeOutcome',
            'userSubscription',
            'cumulativeRoi',
            'daysSubscribed',
            'recentOutcomes'
        ));
    }

    public function show(Trader $trader)
    {
        return view('traders.profile', compact('trader'));
    }

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

        return view('user.trade.leaderboard_user', compact('traders', 'user'));
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


}
