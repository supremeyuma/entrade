<?php

namespace App\Http\Controllers\User;

use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserWalletController extends Controller
{
    public function index()
    {
        $wallets = Auth::user()->wallets;
        return view('user.wallets.index', compact('wallets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cryptocurrency' => 'required|string',
            'wallet_address' => 'required|string',
            'network' => 'nullable|string',
            'label' => 'nullable|string|max:100',
        ]);

        Auth::user()->wallets()->create($request->all());

        return back()->with('success', 'Wallet added successfully.');
    }

    public function update(Request $request, UserWallet $wallet)
    {
        $this->authorize('update', $wallet); // Ensure ownership

        $request->validate([
            'cryptocurrency' => 'required|string',
            'wallet_address' => 'required|string',
            'network' => 'nullable|string',
            'label' => 'nullable|string|max:100',
        ]);

        $wallet->update($request->all());

        return back()->with('success', 'Wallet updated.');
    }

    public function destroy(UserWallet $wallet)
    {
        $this->authorize('delete', $wallet); // Ensure ownership

        $wallet->delete();

        return back()->with('success', 'Wallet deleted.');
    }
}
