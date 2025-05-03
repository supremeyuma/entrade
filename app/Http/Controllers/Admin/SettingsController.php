<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SettingsController extends Controller
{
    public function index()
{
    $depositsEnabled = SiteSetting::get('deposits_enabled', '1');
    return view('admin.settings.index', compact('depositsEnabled'));
}

public function update(Request $request)
{
    $request->validate(['deposits_enabled' => 'required|in:0,1']);
    SiteSetting::set('deposits_enabled', $request->deposits_enabled);

    return back()->with('success', 'Settings updated successfully.');
}

}
