<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserPreferencesController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'language' => 'nullable|in:en,fr,es,de',
            'timezone' => 'nullable|timezone',
            'email_notifications' => 'nullable|boolean',
        ], [], [], 'preferences');

        $settings = $request->user()->settings()->firstOrCreate([]);

        $settings->update([
            'language' => $validated['language'],
            'timezone' => $validated['timezone'],
            'email_notifications' => $request->has('email_notifications'),
        ]);

        return back()->with('pref_success', 'Preferences updated successfully.');
    }
}
