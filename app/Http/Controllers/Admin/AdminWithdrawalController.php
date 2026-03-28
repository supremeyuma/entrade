<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class AdminWithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('user')->latest()->paginate(20);
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'status' => 'required|in:unconfirmed,pending,approved,rejected,completed,cancelled',
            'admin_note' => 'nullable|string',
        ]);

        $previousStatus = $withdrawal->status;
        $newStatus = $request->status;

        $withdrawal->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        // If admin is rejecting a confirmed withdrawal → refund balance
        if (
            $newStatus === 'rejected' &&
            $withdrawal->confirmed_at &&
            $previousStatus !== 'rejected'
        ) {
            $withdrawal->user->increment('balance', $withdrawal->amount);
        }

        return redirect()->back()->with('success', 'Withdrawal status updated.');

    }
}
