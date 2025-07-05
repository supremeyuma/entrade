<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'dob' => 'nullable|date|before:today',
        ]);

        $user->update($request->only('name', 'phone_number', 'country', 'dob'));

        return back()->with('success', 'Profile updated successfully.');
    }

}