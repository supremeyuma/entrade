<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\TradeHistory;
use App\Http\Controllers\Controller;

class TradeHistoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $histories = TradeHistory::where('user_id', $user->id)
            ->with('trader', 'tradeOutcome')
            ->latest()
            ->paginate(10);

        return view('user.trade.history', compact('histories'));
    }
}
