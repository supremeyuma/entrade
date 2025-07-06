<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAccountController extends Controller
{   
    public function index()
    {
        $user = auth()->user();
    
        // Preload user-specific data needed across account sections
        $notifications = $user->notifications()->latest()->paginate(10); // Optional preview
        $referrals = $user->referralsMade()->with('referred')->latest('referred_at')->take(5)->get();
        $kyc = $user->kycVerification;
        $settings = $user->accountSetting;
        $logs = $user->activityLogs()->latest()->paginate(15);
    
        return view('user.accounts', compact('user', 'notifications', 'referrals', 'kyc', 'settings', 'logs'));
    }

    
    public function notifications()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(10);

        return view('user.account-sections.notifications', compact('notifications'));
    }

    public function activityLog()
    {
        $logs = auth()->user()
            ->activityLogs()
            ->latest()
            ->paginate(15);

        return view('user.account-sections.activity-log', compact('logs'));
    }



    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided password is incorrect.'],
            ])->errorBag('deleteAccount');
        }

        Auth::logout();

        $user->delete(); // uses Laravel's SoftDeletes if enabled

        return redirect('/')->with('delete_success', 'Your account has been permanently deleted.');
    }
}