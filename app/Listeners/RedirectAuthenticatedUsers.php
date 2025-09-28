<?php

namespace App\Listeners;

use Laravel\Fortify\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class RedirectAuthenticatedUsers
{
    public function handle(Login $event)
    {
        $user = $event->user;

        if ($user->role === 'admin') {
            session(['url.intended' => '/admin/dashboard']);
        } elseif (!$user->kycVerification && !session()->has('kyc_skipped')) {
            session(['url.intended' => '/kyc']);
        } else {
            session(['url.intended' => '/user/dashboard']);
        }
    }
}
