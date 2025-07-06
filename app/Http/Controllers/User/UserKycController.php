<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserKycController extends Controller
{
    public function submit(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'id_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'proof_of_address' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [], [], 'kyc');

        $kyc = $user->kyc()->firstOrNew();

        if ($kyc->status === 'pending') {
            return back()->with('kyc_success', 'Your documents are already under review.');
        }

        // Upload files
        $idPath = $request->file('id_document')->store('kyc/id_documents', 'public');
        $addressPath = $request->file('proof_of_address')->store('kyc/proof_of_address', 'public');

        $kyc->fill([
            'id_document' => $idPath,
            'proof_of_address' => $addressPath,
            'status' => 'pending',
            'rejection_reason' => null,
        ])->save();

        return back()->with('kyc_success', 'Documents submitted successfully. Please wait for verification.');
    }
}
