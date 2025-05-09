<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use App\Helpers\ActivityLogger;

class LogSuccessfulLogout
{
    public function handle(Logout $event)
    {
        ActivityLogger::log('logout', 'User logged out', $event->user->id);
    }
}
