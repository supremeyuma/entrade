<?php

namespace App\Http\Controllers\User;

use App\Models\Trader;
use App\Models\UserTraderSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Balance;
use Illuminate\Support\Collection;
use App\Helpers\ActivityLogger;

class UserTraderSubscriptionController extends Controller
{
    // Subscribe to a trader
    public function subscribe(Request $request, $traderId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();
        $trader = Trader::findOrFail($traderId);

        // 1. Check if the user has enough balance
        $balance = $user->balance;
        if ($balance->main_balance < $request->amount) {
            return back()->with('error', 'Insufficient funds.');
        }

        // 2. Check if multiple subscriptions are allowed
        if ($user->traderSubscriptions->where('trader_id', $traderId)->count() >= 1) {
            $subscriptions = $user->traderSubscriptions()->where('trader_id', $traderId)->get();
            $subscription = $subscriptions->first();
            if ($subscription->status === 'pending_approval') {
                return back()->with('info', 'You already have a pending subscription request for this trader.');
            }

            if ($subscription->status === 'inactive') {
                $subscription->status = 'pending_approval';
                $subscription->allocated_amount = $request->amount;
                $subscription->save();

                \Notification::route('mail', config('app.admin_email'))
                    ->notify(new \App\Notifications\NewSubscriptionRequestNotification($subscription));

                ActivityLogger::log(
                    'subscription_request',
                    'Requested to subscribe to trader: ' . $trader->name . ' (ID: ' . $trader->id . ')',
                    $user->id
                );

        return redirect()->route('user.tradingDashboard')
            ->with('success', 'Your subscription request has been sent for approval.');

            }
            if ($subscription->status === 'active') {
            return back()->with('error', 'You can only follow a trader once.');
            }
        }

        //dd($user->traderSubscriptions->where('trader_id', $traderId)->count());
        
        if (!config('app.allow_multiple_traders') && $user->traderSubscriptions
            ->where('trader_id', !$traderId)->count() >= 1) {
            return back()->with('error', 'You can only follow one trader.');
        }
        

        // 3. Check if a pending request already exists
        $existingPending = $user->traderSubscriptions()
            ->where('trader_id', $traderId)
            ->where('status', 'pending_approval')
            ->first();

        if ($existingPending) {
            return back()->with('info', 'You already have a pending subscription request for this trader.');
        }

        // 4. Create the pending subscription request
        $subscription = new UserTraderSubscription([
            'trader_id'         => $traderId,
            'user_id'           => $user->id,
            'allocated_amount'  => $request->amount,
            'status'            => 'pending_approval', // ✅ Not active yet
        ]);

        $user->traderSubscriptions()->save($subscription);

        // 5. Notify admin (assuming you have a Notification class)
        \Notification::route('mail', config('app.admin_email'))
            ->notify(new \App\Notifications\NewSubscriptionRequestNotification($subscription));

        // 6. Log the activity
        ActivityLogger::log(
            'subscription_request',
            'Requested to subscribe to trader: ' . $trader->name . ' (ID: ' . $trader->id . ')',
            $user->id
        );

        return redirect()->route('user.tradingDashboard')
            ->with('success', 'Your subscription request has been sent for approval.');
    }


    // Unsubscribe from a trader
    public function unsubscribe($subscriptionId)
    {
        $subscription = UserTraderSubscription::findOrFail($subscriptionId);
        $balance = $subscription->user->balance;

        // Refund the allocated amount to main balance and deduct from trade balance
        $balance->trade_balance -= $subscription->allocated_amount;
        $balance->main_balance += $subscription->allocated_amount;
        $balance->save();

        // Mark subscription as inactive
        $subscription->status = 'inactive';
        $subscription->save();

        ActivityLogger::log('unsubscribe', 'Unsubscribed from trader: ' . $subscription->trader->name . ' (ID: ' . $subscription->trader->id . ')', auth()->id());


        return back()->with('success', 'Unsubscribed from trader.');
    }

    // Update allocated amount for a trader subscription
    public function updateAllocation(Request $request, $subscriptionId)
    {
        $subscription = UserTraderSubscription::findOrFail($subscriptionId);
        $balance = $subscription->user->balance;

        // Check if user has sufficient balance
        if ($balance->main_balance < $request->amount) {
            return back()->with('error', 'Insufficient funds.');
        }

        // Update allocated amount and balances
        $balance->main_balance -= ($request->amount - $subscription->allocated_amount);
        $balance->trade_balance += ($request->amount - $subscription->allocated_amount);
        $balance->save();

        $subscription->allocated_amount = $request->amount;
        $subscription->save();

        ActivityLogger::log('update_allocation', 'Updated allocation for trader: ' . $subscription->trader->name . ' (ID: ' . $subscription->trader->id . ') to ' . $request->input('allocation_amount'), auth()->id());


        return back()->with('success', 'Subscription amount updated.');
    }

    // Transfer funds between main and trade balances
    public function transferFunds(Request $request)
    {
        $user = auth()->user();
        $balance = $user->balance;

        if ($request->transfer_type == 'main_to_trade') {
            if ($balance->main_balance < $request->amount) {
                return back()->with('error', 'Insufficient funds.');
            }

            $balance->main_balance -= $request->amount;
            $balance->trade_balance += $request->amount;
        } elseif ($request->transfer_type == 'trade_to_main') {
            if ($balance->trade_balance < $request->amount) {
                return back()->with('error', 'Insufficient funds.');
            }

            $balance->trade_balance -= $request->amount;
            $balance->main_balance += $request->amount;
        }

        $balance->save();

        ActivityLogger::log('transfer_funds', 'Transferred funds: ' . $request->input('amount') . ' from ' . $request->input('from') . ' to ' . $request->input('to'), auth()->id());


        return back()->with('success', 'Funds transferred successfully.');
    }

    public function searchForm(Request $request)
    {
        $user = auth()->user();
        $query = $request->input('search');

        $traders = collect();

        if ($query) {
            $traders = Trader::where('name', 'LIKE', "%{$query}%")
                ->orWhere('trader_id', 'LIKE', "%{$query}%")
                ->get();
        }

        return view('user.trade.search', compact('traders', 'query', 'user'));
    }

    public function showSubscribeForm($traderId)
    {
        $trader = Trader::findOrFail($traderId);

        // Optionally get user’s current subscription if needed for display
        $user = auth()->user();
        $subscription = $user->subscriptions()->where('trader_id', $trader->id)->first();

        return view('user.trade.subscribe', compact('trader', 'subscription'));
    }

    public function myTraders()
    {
        $user = auth()->user();


        $subscriptions = UserTraderSubscription::with('trader')
            ->where('user_id', $user->id)
            ->get();

        return view('user.trade.dashboard', compact('subscriptions', 'user'));
    }


}
