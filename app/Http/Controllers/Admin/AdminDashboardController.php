<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Trader;
use App\Models\Trade;
use App\Models\Withdrawal;
use App\Models\UserTraderSubscription;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $admins = Role::where('name', 'admin')->first()?->users->count() ?? 0;
        $traders = Trader::count();
        $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();
        $pendingSubscriptions = UserTraderSubscription::where('status', 'pending_approval')->count();


        $recentTrades = Trade::with('trader')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalUsers', 'admins', 'traders', 'pendingWithdrawals', 'pendingSubscriptions', 'recentTrades'));
    }
}
