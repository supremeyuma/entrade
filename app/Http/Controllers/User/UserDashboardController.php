<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;
use App\Models\TradeHistory;


class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load([
            'balance',
            'traderSubscriptions.trader',
        ]);

        $balance = $user->balance;
        $main_balance = (float) ($balance->main_balance ?? 0);
        $trade_balance = (float) ($balance->trade_balance ?? 0);

        $referrals = Referral::where('referrer_id', $user->id)->get();

        $subscriptions = $user->traderSubscriptions;
        $activeSubscriptions = $subscriptions->where('status', 'active')->values();
        $pendingSubscriptions = $subscriptions->where('status', 'pending_approval')->values();
        $activeTraderIds = $activeSubscriptions->pluck('trader_id')->filter();

        $activeTrades = TradeHistory::with(['trader', 'trade'])
            ->where('user_id', $user->id)
            ->when($activeTraderIds->isNotEmpty(), fn ($query) => $query->whereIn('trader_id', $activeTraderIds))
            ->latest()
            ->take(3)
            ->get();

        $recentTrades = TradeHistory::with(['trader', 'trade'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(6)
            ->get();

        // Recent transactions for dashboard widget
        $recentTransactions = $user->transactions()->latest()->take(5)->get();

        $tradeHistoryQuery = TradeHistory::where('user_id', $user->id);
        $tradeHistory = (clone $tradeHistoryQuery)->get();

        $totalReturns = (float) $tradeHistory->sum('amount_returned');
        $totalInvested = (float) $tradeHistory->sum('amount_invested');
        $netProfit = $totalReturns - $totalInvested;
        $averageRoi = (float) ($tradeHistory->avg('roi') ?? 0);
        $winRate = $tradeHistory->count() > 0
            ? round(($tradeHistory->where('roi', '>', 0)->count() / $tradeHistory->count()) * 100, 1)
            : 0;

        $copiedCapital = (float) $activeSubscriptions->sum('allocated_amount');
        $portfolioValue = $main_balance + $trade_balance;
        $thirtyDayProfit = (float) (clone $tradeHistoryQuery)
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('COALESCE(SUM(amount_returned - amount_invested), 0) as profit')
            ->value('profit');

        $bestTrade = $tradeHistory->sortByDesc('roi')->first();
        $worstTrade = $tradeHistory->sortBy('roi')->first();
        $referralBonus = (float) $user->referralBonusTotal();

        $quickStats = [
            [
                'label' => 'Portfolio value',
                'value' => $portfolioValue,
                'type' => 'currency',
                'hint' => 'Main balance + trading balance',
            ],
            [
                'label' => 'Available cash',
                'value' => $main_balance,
                'type' => 'currency',
                'hint' => 'Ready for deposits, withdrawals, or new allocations',
            ],
            [
                'label' => 'Currently copying',
                'value' => $copiedCapital,
                'type' => 'currency',
                'hint' => $activeSubscriptions->count() . ' active trader' . ($activeSubscriptions->count() === 1 ? '' : 's'),
            ],
            [
                'label' => 'Lifetime profit',
                'value' => $netProfit,
                'type' => 'currency_signed',
                'hint' => 'All closed copy trades combined',
            ],
        ];

        return view('user.dashboard', compact(
            'user',
            'main_balance',
            'trade_balance',
            'referrals',
            'subscriptions',
            'activeSubscriptions',
            'pendingSubscriptions',
            'activeTrades',
            'recentTrades',
            'recentTransactions',
            'totalReturns',
            'totalInvested',
            'netProfit',
            'averageRoi',
            'winRate',
            'copiedCapital',
            'portfolioValue',
            'thirtyDayProfit',
            'bestTrade',
            'worstTrade',
            'referralBonus',
            'quickStats',
        ));
    }
}
