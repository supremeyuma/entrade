<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use Illuminate\Http\Request;

class AdminKycController extends Controller
{
    public function index()
    {
        $kycs = KycVerification::with('user')->latest()->paginate(20);
        return view('admin.kyc.index', compact('kycs'));
    }

    public function show(KycVerification $kyc)
    {
        return view('admin.kyc.show', compact('kyc'));
    }

    public function approve(KycVerification $kyc)
    {
        $kyc->update(['status' => 'verified', 'rejection_reason' => null]);

        return redirect()->route('admin.kyc.index')->with('success', 'KYC approved.');
    }

    public function reject(Request $request, KycVerification $kyc)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $kyc->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('reason'),
        ]);

        return redirect()->route('admin.kyc.index')->with('success', 'KYC rejected with reason.');
    }
}
