<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;
use App\Models\TradeOutcome;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $balance = $user->wallet_balance;

        $referrals = Referral::where('referrer_id', $user->id)->get();

        $activeTrades = TradeOutcome::with('trader')
            ->whereIn('trader_id', $user->copiedTraders()->pluck('trader_id'))
            ->latest()->take(3)
            ->get();

        $recentTrades = TradeOutcome::with('trader')
            ->whereIn('trader_id', $user->copiedTraders()->pluck('trader_id'))
            ->latest()->take(5)
            ->get();

        // Calculate portfolio stats
        $totalReturns = $user->tradeOutcomes()->sum('pnl');
        $totalInvested = $user->copiedTraders()->sum('amount');
        $netProfit = $totalReturns;

        $portfolioSummary = [
            'total_invested' => $totalInvested,
            'total_returns' => $totalReturns,
            'net_profit' => $netProfit,
        ];

        return view('user.dashboard', compact(
            'user',
            'balance',
            'referrals',
            'activeTrades',
            'recentTrades',
            'portfolioSummary'
        ));
    }
}
