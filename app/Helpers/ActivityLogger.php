<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($actionType, $description, $userId = null, $metadata = [])
    {
        if (self::isLoggingEnabled($actionType)) {
            ActivityLog::create([
                'user_id' => $userId ?? Auth::id(),
                'action_type' => $actionType,
                'description' => $description,
                'metadata' => $metadata,
            ]);
        }
    }

    protected static function isLoggingEnabled($actionType)
    {
        // Example config toggle → could also come from database
        $enabledLogs = config('logging.activity_log_enabled', [
            'login' => true,
            'logout' => true,
            'subscription' => true,
            'trade_outcome_entry' => true,
            // Add more as needed
        ]);

        return $enabledLogs[$actionType] ?? false;
    }
}
