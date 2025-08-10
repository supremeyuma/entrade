<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KycDetail;
use Illuminate\Support\Facades\Auth;

class KycController extends Controller
{
    public function create()
    {
        return view('kyc.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'identification_type' => 'required|string|max:50',
            'identification_number' => 'required|string|max:50',
            'passport_number' => 'nullable|string|max:50',
            'id_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'passport_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $kyc = new KycDetail($request->except(['id_document', 'passport_document']));
        $kyc->user_id = Auth::id();

        if ($request->hasFile('id_document')) {
            $kyc->id_document_path = $request->file('id_document')->store('kyc_documents', 'public');
        }

        if ($request->hasFile('passport_document')) {
            $kyc->passport_document_path = $request->file('passport_document')->store('kyc_documents', 'public');
        }

        $kyc->save();

        return redirect('/user/dashboard')->with('success', 'KYC details submitted successfully.');
    }

    public function skip()
    {
        $user = auth()->user();
        $user->kyc_skipped = true;
        $user->save();

        return redirect('/user/dashboard')->with('info', 'You have skipped KYC. You can complete it anytime from your profile.');
    }
}
