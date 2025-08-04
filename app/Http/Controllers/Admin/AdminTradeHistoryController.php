<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\Trader;
use App\Models\User;
use App\Models\TradeHistory;
use Illuminate\Http\Request;

class AdminTradeHistoryController extends Controller
{
    public function create()
    {
        return view('admin.trade_histories.create', [
            'users' => User::all(),
            'traders' => Trader::all(),
            'trades' => Trade::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            //'trade_id' => 'required|exists:trades,id',
            'user_id' => 'required|exists:users,id',
            'trader_id' => 'required|exists:traders,id',
            //'amount_invested' => 'required|numeric|min:0',
            'roi' => 'required|numeric',
            'amount_returned' => 'required|numeric|min:0',
            //'new_trade_balance' => 'nullable|numeric',
            'symbol' => 'required|string',
        ]);

        $old_trade_balance = (TradeHistory::where('user_id', $validated['user_id'])->latest('created_at')->first())->new_trade_balance;
        //dd($old_trade_balance);
        
        $new_trade_balance = $validated['amount_returned'] + $old_trade_balance;

        

        $tradeData = [
            'user_id' => $validated['user_id'],
            'trader_id' => $validated['trader_id'],
            'roi' => $validated['roi'],
            'amount_returned' => $validated['amount_returned'],
            'new_trade_balance' => $new_trade_balance,
        ];

        //dd( $trade);

        TradeHistory::create($tradeData);

        return redirect()->back()->with('success', 'Trade history manually added.');
    }
}
