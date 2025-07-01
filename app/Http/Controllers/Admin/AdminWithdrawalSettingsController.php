<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalSetting;
use Illuminate\Http\Request;

class AdminWithdrawalSettingsController extends Controller
{
    public function index()
    {
        $settings = WithdrawalSetting::all();
        return view('admin.withdrawal-settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cryptocurrency' => 'required|string|unique:withdrawal_settings',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|gt:min_amount',
            'fixed_fee' => 'required|numeric|min:0',
            'percent_fee' => 'required|numeric|min:0',
        ]);

        WithdrawalSetting::create($data);
        return back()->with('success', 'Withdrawal setting saved.');
    }
}
