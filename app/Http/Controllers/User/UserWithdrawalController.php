<?php

namespace App\Http\Controllers\User;

use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\WithdrawalSetting;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawalConfirmationMail;


class UserWithdrawalController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $wallets = $user->wallets;

        // feeSettings: e.g. ['BTC' => ['fixed' => 0.0001, 'percent' => 0.1], ...]
        $feeSettings = WithdrawalSetting::all()
            ->keyBy('cryptocurrency')
            ->map(function ($item) {
                return [
                    'fixed' => $item->fixed_fee,
                    'percent' => $item->percent_fee,
                ];
            })
            ->toArray();

        // wallet info map: wallet_address → { cryptocurrency, network }
        $walletInfo = $wallets->mapWithKeys(function ($wallet) {
            return [
                $wallet->wallet_address => [
                    'cryptocurrency' => $wallet->cryptocurrency,
                    'network' => $wallet->network,
                ],
            ];
        })->toArray();

        // crypto → networks map
        $cryptoNetworks = WithdrawalSetting::all()
            ->keyBy('cryptocurrency')
            ->map(function ($item) {
                return $item->networks;
            })
            ->toArray();

        return view('user.withdrawals.create', compact(
            'wallets', 'feeSettings', 'walletInfo', 'cryptoNetworks'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cryptocurrency' => 'required|string|exists:withdrawal_settings,cryptocurrency',
            'amount' => 'required|numeric|min:0.00000001',
            'wallet_address' => 'required|string',
            'network' => 'nullable|string',
            'code' => 'nullable|string',
        ]);

        $user = Auth::user();
        $setting = WithdrawalSetting::where('cryptocurrency', $request->cryptocurrency)->firstOrFail();
        $amount = $request->amount;

        // Validate network is allowed
        $allowed = $setting->networks ?? [];
        if ($request->network && ! in_array($request->network, $allowed)) {
            return back()->withErrors(['network' => 'Invalid network for this cryptocurrency.'])
                         ->withInput();
        }

        // validate min / max
        if ($amount < $setting->min_amount || $amount > $setting->max_amount) {
            return back()->withErrors([
                'amount' => "Amount must be between {$setting->min_amount} and {$setting->max_amount} {$request->cryptocurrency}."
            ])->withInput();
        }

        // calculate fee
        $fee = $setting->fixed_fee + ($setting->percent_fee / 100) * $amount;

        // check balance
        if ($amount > $user->balance) {
            return back()->withErrors(['amount' => 'Insufficient balance.'])->withInput();
        }

        // If user selected a saved wallet, ensure the wallet's crypto & network match
        if ($request->wallet_address) {
            $wallet = $user->wallets()->where('wallet_address', $request->wallet_address)->first();
            if ($wallet) {
                if ($wallet->cryptocurrency !== $request->cryptocurrency
                    || $wallet->network !== $request->network) {
                    return back()->withErrors([
                        'wallet_address' => 'Selected wallet does not match the chosen cryptocurrency or network.'
                    ])->withInput();
                }
            }
        }

        $withdrawal = Withdrawal::create([
            'user_id' => $user->id,
            'cryptocurrency' => $request->cryptocurrency,
            'amount' => $amount,
            'fee' => $fee,
            'wallet_address' => $request->wallet_address,
            'network' => $request->network,
            'status' => 'unconfirmed',
            'confirmation_token' => Str::uuid(),
            'attempts' => 0,
        ]);

        // send confirmation email
        Mail::to($user->email)->send(new \App\Mail\WithdrawalConfirmationMail($withdrawal));

        return redirect()->route('user.withdrawals.confirm', $withdrawal->confirmation_token);
    }

    public function confirm($token)
    {
        $withdrawal = Withdrawal::where('confirmation_token', $token)
            ->whereNull('cancelled_at')
            ->firstOrFail();

        if ($withdrawal->confirmed_at) {
            return redirect()->route('user.withdrawals.index')
                ->with('success', 'Already confirmed.');
        }

        return view('user.withdrawals.confirm', compact('withdrawal'));
    }

    public function processConfirmation(Request $request)
    {
        $request->validate([
            'token' => 'required|uuid',
            'code' => 'required|string',
        ]);

        $withdrawal = Withdrawal::where('confirmation_token', $request->token)
            ->whereNull('cancelled_at')
            ->firstOrFail();

        $user = $withdrawal->user;

        if ($withdrawal->attempts >= 3) {
            $withdrawal->update(['status' => 'cancelled', 'cancelled_at' => now()]);
            return redirect()->route('user.withdrawals.index')
                ->withErrors(['error' => 'Too many invalid attempts. Withdrawal cancelled.']);
        }

        $valid = ! $user->two_factor_secret
            || app('pragmarx.google2fa')->verifyKey($user->two_factor_secret, $request->code);

        if (! $valid) {
            $withdrawal->increment('attempts');
            return back()->withErrors([
                'code' => 'Invalid code. Attempts left: ' . (3 - $withdrawal->attempts)
            ]);
        }

        if ($user->balance < $withdrawal->amount) {
            $withdrawal->update(['status' => 'cancelled', 'cancelled_at' => now()]);
            return redirect()->route('user.withdrawals.index')
                ->withErrors(['error' => 'Insufficient balance at confirmation time. Withdrawal cancelled.']);
        }

        $user->decrement('balance', $withdrawal->amount);

        $withdrawal->update([
            'confirmed_at' => now(),
            'confirmation_token' => null,
            'status' => 'pending', 
        ]);

        return redirect()->route('user.withdrawals.index')
            ->with('success', 'Withdrawal confirmed and submitted.');
    }

    public function history(Request $request)
    {
        $query = auth()->user()->withdrawals();

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

        $withdrawals = $query->get();

        return view('user.withdrawals.history', compact('withdrawals'));
    }
}