<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteSetting;

class CheckDepositsEnabled
{
    public function handle($request, Closure $next)
    {
        $enabled = SiteSetting::get('deposits_enabled', '1');

        if ($enabled !== '1') {
            return redirect()->route('dashboard')->withErrors('Deposits are currently disabled.');
        }

        return $next($request);
    }
}
