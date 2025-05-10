<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReferralController extends Controller
{
    public function index()
    {
        $referrals = Auth::user()->referralsMade()->with('referred')->get();
        return view('user.referrals.index', compact('referrals'));
    }
}
