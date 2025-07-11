<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SiteSettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            SiteSetting::set($key, is_array($value) ? json_encode($value) : $value);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
    
    public function referralSettings()
    {
        $settings = SiteSetting::whereIn('key', [
            'referral_enabled',
            'referral_bonus_enabled',
            'referral_bonus_type',
            'referral_bonus_amount',
            'referral_bonus_credit_to',
            'referral_tiered_enabled',
            'referral_link_expiry_days',
        ])->get();

        return view('admin.site_settings.referral', compact('settings'));
    }

    public function updateReferralSettings(Request $request)
    {
        foreach ($request->input('settings') as $key => $value) {
            SiteSetting::where('key', $key)->update(['value' => $value]);
        }

        return redirect()->route('admin.site_settings.referral')->with('success', 'Referral settings updated.');
    }
}
