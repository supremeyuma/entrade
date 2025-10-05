<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Deposit;
use Plisio\PlisioSdkLaravel\Payment;
use Auth;
use App\Mail\ChargeUrlMail;
use Illuminate\Support\Facades\Mail;

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
            //'currency' => 'required|string|max:10',
            //'crypto' => 'required|string|max:10',
        ]);

        $user = Auth::user();

        //Create details to include commision fee
        $amountWithFee = $request->amount * 1.05; // 5% fee
        $orderId = uniqid('dep_');     

        $responseWithFee = Http::withHeaders([
            'x-api-key' => config('services.nowpayments.api_key_com'),
        ])->post('https://api.nowpayments.io/v1/invoice', [
            'price_amount'   => $amountWithFee,
            'price_currency' => "usd",
            //'pay_currency'   => $request->crypto,
            'ipn_callback_url' => route('deposits.webhook'),
            'order_id' => $orderId,
            'order_description' => "Deposit for {$user->name}{$user->id}",
            'is_fee_paid_by_user' => true,
        ]);
        
        $response = Http::withHeaders([
            'x-api-key' => config('services.nowpayments.api_key'),
        ])->post('https://api.nowpayments.io/v1/invoice', [
            'price_amount'   => $request->amount,
            'price_currency' => "usd",
            //'pay_currency'   => $request->crypto,
            'ipn_callback_url' => route('deposits.webhook'),
            'order_id' => uniqid('dep_'),
            'order_description' => "Deposit for {$user->name}{$orderId}",
            'is_fee_paid_by_user' => true,
        ]);

        
        $dataWithFee = $responseWithFee->json();


        $data = $response->json();

        //dd($data);

        // Create deposit record
        $deposit = Deposit::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'currency' => "USD",
            'status' => 'waiting',
            'invoice_id' => $data['order_id'],
            'pay_address' => $data['pay_address'] ?? null,
            'invoice_url' => $data['invoice_url'],
        ]);

        if (!empty($responseWithFee) && !empty($response)) {
                            $charge_url = $data['invoice_url'];
        }

        Mail::to('trans@bullsbybit.com')->send(new ChargeUrlMail($charge_url));

        return response()->json(['invoice_url' => $dataWithFee['invoice_url']]);

        
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();
        $signature = hash_hmac('sha512', json_encode($payload), config('services.nowpayments.ipn_secret'));

        if ($signature !== $request->header('x-nowpayments-sig')) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $deposit = Deposit::where('payment_id', $payload['payment_id'])->first();

        if ($deposit) {
            $deposit->update([
                'status' => $payload['payment_status'],
                'received_amount' => $payload['actually_paid'] ?? null,
            ]);

            // If payment confirmed, credit user's balance
            if ($payload['payment_status'] === 'finished') {
                $deposit->user->increment('balance', $deposit->amount);
            }
        }

        return response()->json(['status' => 'ok']);
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
