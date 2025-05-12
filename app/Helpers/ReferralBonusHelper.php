<?php


namespace App\Helpers;

use App\Models\SiteSetting;

class ReferralBonusHelper
{
    public static function isTriggerEnabled(string $triggerKey): bool
    {
        return SiteSetting::where('key', $triggerKey)->value('value') === '1';
    }
}
