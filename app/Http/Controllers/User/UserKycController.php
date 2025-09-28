<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use Illuminate\Http\Request;

class UserKycController extends Controller
{
    public function create()
    {
        return view('kyc.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'phone'                => 'required|string|max:20',
            'country'              => 'required|string|max:100',
            'address'              => 'required|string|max:255',
            'identification_type'  => 'required|string|max:50',
            'identification_number'=> 'required|string|max:50',
            'passport_number'      => 'nullable|string|max:50',
            'id_document'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'proof_of_address'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'passport_document'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $kyc = $user->kycVerification()->firstOrNew();

        if ($kyc->status === 'pending') {
            return back()->with('kyc_success', 'Your documents are already under review.');
        }

        // Upload required documents
        $idPath       = $request->file('id_document')->store('kyc/id_documents', 'public');
        $addressPath  = $request->file('proof_of_address')->store('kyc/proof_of_address', 'public');

        // Upload optional passport
        $passportPath = $request->hasFile('passport_document')
            ? $request->file('passport_document')->store('kyc/passports', 'public')
            : null;

        // Save everything
        $kyc->fill([
            'phone'                => $request->phone,
            'country'              => $request->country,
            'address'              => $request->address,
            'identification_type'  => $request->identification_type,
            'identification_number'=> $request->identification_number,
            'passport_number'      => $request->passport_number,
            'id_document'          => $idPath,
            'proof_of_address'     => $addressPath,
            'passport_document'    => $passportPath,
            'status'               => 'pending',
            'rejection_reason'     => null,
        ])->save();

        return route('user.dashboard')->with('kyc_success', 'KYC submitted successfully. Please wait for verification.');
    }

    public function skip(Request $request)
    {
        $request->user()->update(['kyc_skipped' => true]);
        return redirect()->route('user.dashboard')->with('status', 'You skipped KYC for now.');
    }
}
