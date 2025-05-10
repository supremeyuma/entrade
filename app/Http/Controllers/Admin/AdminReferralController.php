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

    $bonusAmount = $referral->bonus_amount ?? 10; // fallback

    $referral->update([
        'status' => 'paid',
    ]);

    $referral->referrer->increment('balance', $bonusAmount);

    ActivityLogger::log('referral_bonus_paid', 'Referral bonus approved and paid', $referral->referrer_id);

    return back()->with('success', 'Referral bonus approved and paid.');
}

}
