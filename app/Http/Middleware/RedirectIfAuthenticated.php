<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guard = $guards[0] ?? null;

        if (Auth::guard($guard)->check()) {
            $user = Auth::user();

            if (strtolower(trim($user->role)) === 'admin') {
                return redirect('/admin/dashboard');
            }

            if (!$user->kycVerification && !session()->has('kyc_skipped')) {
                return redirect('/kyc');
            }

            return redirect('/user/dashboard');
        }

        return $next($request);
    }
}
