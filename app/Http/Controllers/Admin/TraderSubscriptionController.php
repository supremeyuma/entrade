<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserTraderSubscription;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class TraderSubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = UserTraderSubscription::with(['user', 'trader'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function show($id)
    {
        $subscription = UserTraderSubscription::with(['user', 'trader'])->findOrFail($id);
        return view('admin.subscriptions.show', compact('subscription'));
    }

    public function approve(Request $request, $id)
    {
        $subscription = UserTraderSubscription::with(['user', 'user.balance', 'trader'])->findOrFail($id);

        if ($subscription->status !== 'pending_approval') {
            return back()->with('error', 'This request has already been processed.');
        }

        $balance = $subscription->user->balance;
        if ($balance->main_balance < $subscription->allocated_amount) {
            return back()->with('error', 'User does not have enough balance to approve this request.');
        }

        // Deduct balance and update trade balance
        $balance->main_balance -= $subscription->allocated_amount;
        $balance->trade_balance += $subscription->allocated_amount;
        $balance->save();

        $subscription->status = 'active';
        $subscription->admin_comment = $request->admin_comment;
        $subscription->save();

        ActivityLogger::log(
            'subscription_approved',
            "Approved subscription for {$subscription->user->name} to trader {$subscription->trader->name}",
            auth()->id()
        );

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $subscription = UserTraderSubscription::findOrFail($id);

        if ($subscription->status !== 'pending_approval') {
            return back()->with('error', 'This request has already been processed.');
        }

        $subscription->status = 'rejected';
        $subscription->admin_comment = $request->admin_comment;
        $subscription->save();

        ActivityLogger::log(
            'subscription_rejected',
            "Rejected subscription request from {$subscription->user->name} to trader {$subscription->trader->name}",
            auth()->id()
        );

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription rejected.');
    }
}
