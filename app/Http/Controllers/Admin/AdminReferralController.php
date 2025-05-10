<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;

class AdminReferralController extends Controller
{
    public function index()
    {
        $referrals = Referral::with(['referrer', 'referred'])->latest()->paginate(20);
        return view('admin.referrals.index', compact('referrals'));
    }

    public function approve(Referral $referral)
    {
        if ($referral->status !== 'pending') {
            return back()->with('error', 'Referral already processed.');
        }

        // Fetch bonus type and value from site settings
        $bonusType = \App\Models\SiteSetting::where('key', 'referral_bonus_type')->value('value');
        $bonusValue = \App\Models\SiteSetting::where('key', 'referral_bonus_value')->value('value');

        $bonusAmount = 0;

        // If referred user has a deposit amount recorded (optional logic, else fixed amount/percentage applies)
        $referredDepositAmount = $referral->referred->deposits()->sum('amount') ?? 0;

        if ($bonusType === 'percentage') {
            $bonusAmount = $referredDepositAmount * ($bonusValue / 100);
        } elseif ($bonusType === 'fixed') {
            $bonusAmount = $bonusValue;
        }

        // Optionally fallback if deposit not available
        if ($bonusAmount <= 0) {
            $bonusAmount = $referral->bonus_amount ?? 0;
        }

        // Update referral status
        $referral->update([
            'status' => 'paid',
            'bonus_amount' => $bonusAmount,
        ]);

        // Credit referrer balance
        $referral->referrer->increment('balance', $bonusAmount);

        // Log the activity
        \App\Helpers\ActivityLogger::log('referral_bonus_paid', "Referral bonus of {$bonusAmount} approved and paid", $referral->referrer_id);

        return back()->with('success', 'Referral bonus approved and paid.');
    }


}
