<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use App\Models\SiteSetting;

class SettingsHelper
{
    public static function get($key, $default = null)
    {
        return Cache::remember("site_setting_{$key}", 60, function () use ($key, $default) {
            $setting = SiteSetting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function isReferralEnabled()
    {
        return self::get('referral_enabled') === 'true';
    }

    public static function getReferralBonusAmount()
    {
        return self::get('referral_bonus_amount');
    }

    public static function getReferralSetting($key)
    {
        return self::get($key);
    }
}
