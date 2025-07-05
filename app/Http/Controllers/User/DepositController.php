<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;
use Plisio\PlisioSdkLaravel\Payment;
use Auth;

class DepositController extends Controller
{
    public function showForm()
    {
        return view('user.deposits.create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'currency' => 'required|string|max:10',
        ]);

        $user = Auth::user();

        // Create deposit record
        $deposit = Deposit::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'currency' => strtoupper($request->currency),
            'status' => 'pending',
        ]);

        // Initialize Plisio
        $plisioGateway = new Payment(config('plisio.api_key'));

        $data = [
            'order_name' => 'Deposit #' . $deposit->id,
            'order_number' => $deposit->id,
            'source_amount' => number_format($deposit->amount, 8, '.', ''),
            'source_currency' => $deposit->currency,
            'cancel_url' => route('user.deposit.cancel', $deposit->id),
            'callback_url' => route('plisio.callback'),
            'success_url' => route('user.deposit.success', $deposit->id),
            'email' => $user->email,
            'plugin' => 'laravelSdk',
            'version' => '1.0.0',
        ];

        $response = $plisioGateway->createTransaction($data);

        if ($response && $response['status'] !== 'error' && !empty($response['data'])) {
            $deposit->update([
                'invoice_id' => $response['data']['txn_id'],
                'payment_url' => $response['data']['invoice_url'],
            ]);

            return redirect($response['data']['invoice_url']);
        } else {
            return back()->with('error', 'Payment failed to initialize. Please try again.');
        }
    }

    public function history(Request $request)
    {
        $query = auth()->user()->deposits();

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        if ($request->sort === 'amount_asc') {
            $query->orderBy('amount');
        } elseif ($request->sort === 'amount_desc') {
            $query->orderByDesc('amount');
        } elseif ($request->sort === 'date_asc') {
            $query->orderBy('created_at');
        } else {
            $query->orderByDesc('created_at');
        }

        $deposits = $query->get();

        return view('user.deposits.history', compact('deposits'));
    }

}
