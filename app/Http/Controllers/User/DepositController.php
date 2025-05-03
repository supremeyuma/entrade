<?php

namespace App\Http\Controllers\User;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Plisio\PlisioSdkLaravel\Payment;
use App\Http\Controllers\Controller;

class DepositController extends Controller
{
    public function create()
    {
        return view('user.deposits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'currency' => 'required|string',
        ]);

        // Create a deposit record
        $deposit = Deposit::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'currency' => $request->currency,
            'status' => 'pending',
        ]);

        // Initialize Plisio SDK
        $plisioGateway = new Payment(config('plisio.api_key'));

        // Prepare invoice data
        $params = [
            'invoiceid' => $deposit->id,
            'order_description' => 'Deposit to account',
            'amount' => $deposit->amount,
            'currency' => $deposit->currency,
            'clientdetails' => [
                'email' => Auth::user()->email,
            ],
        ];

        $data = [
            'order_name' => 'Deposit #' . $params['invoiceid'],
            'order_number' => $params['invoiceid'],
            'description' => $params['order_description'],
            'source_amount' => number_format($params['amount'], 8, '.', ''),
            'source_currency' => $params['currency'],
            'cancel_url' => route('deposit.index') . '?status=cancelled',
            'callback_url' => route('deposit.callback'),
            'success_url' => route('deposit.index') . '?status=success',
            'email' => $params['clientdetails']['email'],
            'plugin' => 'laravelSdk',
            'version' => '1.0.0',
        ];

        // Create invoice
        $response = $plisioGateway->createTransaction($data);

        // Handle response
        if ($response && $response['status'] !== 'error' && !empty($response['data'])) {
            // Update the deposit with txn_id and payment address if available
            $deposit->update([
                'txn_id' => $response['data']['txn_id'],
                'payment_address' => $response['data']['wallet_address'] ?? null,
            ]);

            // Redirect to Plisio payment page
            return redirect($response['data']['invoice_url']);
        } else {
            $errorMessage = is_array($response['data']['message'])
                ? implode(', ', $response['data']['message'])
                : $response['data']['message'];
            return redirect()->back()->withErrors($errorMessage ?: 'Failed to create payment. Please try again.');
        }
    }


    // Webhook callback from Plisio
    public function callback(Request $request)
    {
        $callbackData = $request->all();

        $plisioGateway = new Payment(config('plisio.api_key'));

        if (!$plisioGateway->verifyCallbackData($callbackData)) {
            return response()->json(['error' => 'Invalid callback data'], 403);
        }

        $txnId = $callbackData['txn_id'] ?? null;
        $status = $callbackData['status'] ?? null;

        if (!$txnId) {
            return response()->json(['error' => 'Transaction ID missing'], 400);
        }

        $deposit = Deposit::where('txn_id', $txnId)->first();

        if (!$deposit) {
            return response()->json(['error' => 'Deposit not found'], 404);
        }

        if ($status === 'completed' && $deposit->status !== 'confirmed') {
            $deposit->update(['status' => 'confirmed']);

            // ✅ Update user balance here
            $deposit->user->increment('balance', $deposit->amount);

        } elseif ($status === 'failed') {
            $deposit->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Deposit updated']);
    }


    public function index()
    {
        $deposits = Auth::user()->deposits()->latest()->get();
        return view('user.deposits.index', compact('deposits'));
    }
}
