<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAccountController extends Controller
{
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