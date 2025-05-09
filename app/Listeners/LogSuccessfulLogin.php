<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Helpers\ActivityLogger;

class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        ActivityLogger::log('login', 'User logged in', $event->user->id);
    }
}