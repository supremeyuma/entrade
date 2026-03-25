<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserImpersonationController extends Controller
{
    public function store(Request $request, User $user): RedirectResponse
    {
        $admin = $request->user();

        abort_unless($admin && $admin->hasRole('admin'), 403);
        abort_if($request->session()->has('impersonator_id'), 400, 'You are already impersonating a user.');
        abort_if($user->is($admin), 422, 'You cannot impersonate your own account.');
        abort_unless($user->hasRole('user'), 422, 'Only regular users can be impersonated.');

        $request->session()->put('impersonator_id', $admin->getKey());
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('user.dashboard')
            ->with('success', "You are now logged in as {$user->name}.");
    }

    public function destroy(Request $request): RedirectResponse
    {
        $impersonatorId = $request->session()->pull('impersonator_id');
        $impersonatedUserId = $request->user()?->getKey();

        abort_unless($impersonatorId, 403);

        $admin = User::find($impersonatorId);

        abort_unless($admin && $admin->hasRole('admin'), 403);

        Auth::guard('web')->login($admin);
        $request->session()->regenerate();

        return redirect()
            ->route('admin.users.show', $impersonatedUserId)
            ->with('success', 'You have returned to your admin account.');
    }
}
