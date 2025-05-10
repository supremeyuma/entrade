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
}
