<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserFundsController extends Controller
{
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'type'          => 'required|in:credit,debit',
            'balance_type'  => 'required|in:main,trading',
            'category'      => 'required|in:deposit,withdrawal,bonus,trade,adjustment',
            'amount'        => 'required|numeric|min:0.01',
            'user_note'     => 'nullable|string|max:1000',
            'admin_note'    => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($user, $validated) {
            $balanceField = $validated['balance_type'] . '_balance';
            $amount = $validated['amount'];

            if ($validated['type'] === 'debit') {
                // Ensure user has enough funds
                if ($user->balance->$balanceField < $amount) {
                    abort(400, 'Insufficient funds.');
                }
                $user->balance->decrement($balanceField, $amount);
            } else {
                $user->balance->increment($balanceField, $amount);
            }

            Transaction::create([
                'user_id'      => $user->id,
                'type'         => $validated['type'],
                'balance_type' => $validated['balance_type'],
                'category'     => $validated['category'],
                'amount'       => $amount,
                'user_note'    => $validated['user_note'],
                'admin_note'   => $validated['admin_note'],
                'meta'         => null,
            ]);
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'Transaction processed successfully.');
    }
}
