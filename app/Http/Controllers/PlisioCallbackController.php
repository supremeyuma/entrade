<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;
use Plisio\PlisioSdkLaravel\Payment;
use App\Models\User;

class PlisioCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $plisioGateway = new Payment(config('plisio.api_key'));

        $callbackData = $request->all();

        if ($plisioGateway->verifyCallbackData($callbackData)) {
            $deposit = Deposit::where('invoice_id', $callbackData['txn_id'])->first();

            if ($deposit && $deposit->status !== 'confirmed' && $callbackData['status'] === 'completed') {
                $deposit->update(['status' => 'confirmed']);

                // Update user balance
                $user = $deposit->user;
                $user->balance += $deposit->amount;
                $user->save();
            }

            return response('OK', 200);
        }

        return response('Forbidden', 403);
    }
}
