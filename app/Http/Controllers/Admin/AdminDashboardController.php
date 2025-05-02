<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $admins = Role::where('name', 'admin')->first()?->users->count() ?? 0;
        $traders = Role::where('name', 'trader')->first()?->users->count() ?? 0;
        
        return view('admin.dashboard', compact('totalUsers', 'admins', 'traders'));
    }
}
