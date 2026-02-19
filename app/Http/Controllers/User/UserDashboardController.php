<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;
use App\Models\TradeOutcome;
use Illuminate\Support\Facades\DB;
use App\Models\Balance;
use App\Models\TradeLog;
use App\Models\TradeHistory;


class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        //dd($user->balance);
        //dd(Balance::where('user_id', $user->id)->first());
        $main_balance = $user->balance->main_balance;

        $trade_balance = $user->balance->trade_balance;

        $referrals = Referral::where('referrer_id', $user->id)->get();

        $traderIds = DB::table('user_trader_subscriptions')
            ->where('user_id', $user->id)
            ->pluck('trader_id');

        $activeTrades = TradeHistory::with('trader')
            ->whereIn('trader_id', $traderIds)
            ->orderBy('trade_histories.created_at', 'desc')
            ->take(3)
            ->get();

        /*$activeTrades = TradeOutcome::with('trader')
            ->whereIn('trader_id', $user->copiedTraders()->pluck('trader_id'))
            ->latest()->take(3)
            ->get();*/

        $recentTrades = TradeHistory::with(['trader', 'trade'])
            ->whereIn('trader_id', $user->copiedTraders()->pluck('user_trader_subscriptions.trader_id'))
            ->latest()
            ->take(5)
            ->get();

        // Recent transactions for dashboard widget
        $recentTransactions = $user->transactions()->latest()->take(5)->get();

        //dd($recentTrades->pluck('trade_id'));

        // Calculate portfolio stats
        
        // Calculate total returns (sum of outputs for user's trades)
        $totalReturns = TradeHistory::where('user_id', $user->id)
            ->sum('amount_returned');

        // Calculate total invested (sum of inputs for user's trades)
        $totalInvested = TradeHistory::where('user_id', $user->id)
            ->sum('amount_invested');

        // Calculate net profit (total returns minus total invested)
        $netProfit = $totalReturns - $totalInvested;

        // Calculate ROI percentage (if you want to show performance)
        $averageRoi = TradeHistory::where('user_id', $user->id)
        ->average('roi');

        return view('user.dashboard', compact(
            'user',
            'main_balance',
            'trade_balance',
            'referrals',
            'activeTrades',
            'recentTrades',
            'recentTransactions',
            'totalReturns',
            'totalInvested',
            'netProfit',
            'averageRoi',
        ));
    }
}
