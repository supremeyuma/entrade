<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trader;
use App\Models\TradeOutcome;
use Illuminate\Http\Request;
use App\Models\UserTraderSubscription;
use App\Models\TradeHistory;
use App\Models\User;

class TradeOutcomeController extends Controller
{
    public function index(Request $request)
    {
        $query = TradeOutcome::with('trader')->latest();

        if ($request->filled('trader_id')) {
            $query->where('trader_id', $request->trader_id);
        }

        $tradeOutcomes = $query->paginate(15);
        $traders = Trader::all();

        return view('admin.trade-outcomes.index', compact('tradeOutcomes', 'traders'));
    }

    public function create()
    {
        $traders = Trader::all();
        return view('admin.trade-outcomes.create', compact('traders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trader_id' => 'required|exists:traders,id',
            'percentage_change' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $tradeOutcome = TradeOutcome::create([
            'trader_id' => $request->trader_id,
            'percentage_change' => $request->percentage_change,
            'description' => $request->description,
        ]);

        // Find all users subscribed to this trader
        $subscriptions = UserTraderSubscription::where('trader_id', $request->trader_id)->get();

        foreach ($subscriptions as $subscription) {
            $user = $subscription->user;
            $currentBalance = $subscription->allocated_amount;
            
            // Calculate gain or loss
            $gainLoss = ($request->percentage_change / 100) * $currentBalance;
            $newBalance = $currentBalance + $gainLoss;

            // Update the subscription's allocated amount (if applicable)
            $subscription->update([
                'allocated_amount' => $newBalance
            ]);

            // Optionally, update the user’s trade balance too:
            // $user->increment('trade_balance', $gainLoss);

            // Log the trade history
            TradeHistory::create([
                'user_id' => $user->id,
                'trader_id' => $request->trader_id,
                'trade_outcome_id' => $tradeOutcome->id,
                'previous_balance' => $currentBalance,
                'change' => $gainLoss,
                'new_balance' => $newBalance,
            ]);

            // Optionally send a notification (if implemented)
            $user->notify(new TradeOutcomeNotification($tradeOutcome, $gainLoss));
        }

        return redirect()->back()->with('success', 'Trade outcome saved and users updated successfully.');
    }

    public function show($id)
    {
        $tradeOutcome = TradeOutcome::findOrFail($id);

        return view('user.trade.outcome_show', compact('tradeOutcome'));
    }

}
