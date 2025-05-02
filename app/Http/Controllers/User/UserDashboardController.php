<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Placeholder data - replace with real logic later
        $balance = 1000; // Assume $1000 balance for now
        $activeTrades = [
            ['trader' => 'Trader Alpha', 'status' => 'Active', 'profit' => '5%'],
            ['trader' => 'Trader Beta', 'status' => 'Paused', 'profit' => '2%'],
        ];
        $portfolioSummary = [
            'total_invested' => 2000,
            'total_returns' => 2200,
            'net_profit' => 200,
        ];

        return view('user.dashboard', compact('user', 'balance', 'activeTrades', 'portfolioSummary'));
    }
}
