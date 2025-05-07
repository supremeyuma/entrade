<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TradeOutcome;

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



}
