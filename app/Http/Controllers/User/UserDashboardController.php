<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;
use App\Models\TradeOutcome;
use Illuminate\Support\Facades\DB;
use App\Models\Balance;


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

        $activeTrades = TradeOutcome::with('trader')
            ->whereIn('trader_id', $traderIds)
            ->orderBy('trade_outcomes.created_at', 'desc')
            ->take(3)
            ->get();

        /*$activeTrades = TradeOutcome::with('trader')
            ->whereIn('trader_id', $user->copiedTraders()->pluck('trader_id'))
            ->latest()->take(3)
            ->get();*/

        $recentTrades = TradeOutcome::with('trader')
            ->whereIn('trader_id', $user->copiedTraders()->pluck('user_trader_subscriptions.trader_id'))
            ->latest()->take(5)
            ->get();

        // Calculate portfolio stats
        $totalReturns = $user->tradeOutcomes()->sum('pnl');
        $totalInvested = $user->copiedTraders()->sum('allocated_amount');
        $netProfit = $totalReturns;

        $portfolioSummary = [
            'total_invested' => $totalInvested,
            'total_returns' => $totalReturns,
            'net_profit' => $netProfit,
        ];

        return view('user.dashboard', compact(
            'user',
            'main_balance',
            'trade_balance',
            'referrals',
            'activeTrades',
            'recentTrades',
            'portfolioSummary'
        ));
    }
}
