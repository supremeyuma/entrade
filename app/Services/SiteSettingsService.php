<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteSettingsService
{
    public function get(array $keys = []): array
    {
        // Example: fetching from a `settings` table
        $query = DB::table('site_settings');

        if (!empty($keys)) {
            $query->whereIn('key', $keys);
        }

        return $query->pluck('value', 'key')->toArray();
    }
}
