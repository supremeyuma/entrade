<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserSecurityController extends Controller
{
    public function changePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'The current password is incorrect.',
            ])->errorBag('security');
        }

        $user->update([
            'password' => bcrypt($validated['new_password']),
        ]);

        return back()->with('security_success', 'Password updated successfully.');
    }

    public function enable2FA(Request $request)
    {
        $user = $request->user();
        $settings = $user->settings()->firstOrCreate([]);
        $settings->update(['two_factor_enabled' => true]);

        return back()->with('security_success', 'Two-Factor Authentication enabled.');
    }

    public function disable2FA(Request $request)
    {
        $user = $request->user();
        $settings = $user->settings()->first();

        if ($settings) {
            $settings->update(['two_factor_enabled' => false]);
        }

        return back()->with('security_success', 'Two-Factor Authentication disabled.');
    }

}
