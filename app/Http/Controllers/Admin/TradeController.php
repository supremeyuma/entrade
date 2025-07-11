<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\Trader;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function create(Trader $trader)
    {
        return view('admin.trades.create', compact('trader'));
    }

    public function store(Request $request, Trader $trader)
    {
        $validated = $request->validate([
            'asset'         => 'required|string|max:50',
            'pair'          => 'nullable|string|max:20',
            'trade_type'    => 'required|in:buy,sell',
            'entry_price'   => 'required|numeric',
            'exit_price'    => 'required|numeric',
            'lot_size'      => 'nullable|numeric',
            'stop_loss'     => 'nullable|numeric',
            'take_profit'   => 'nullable|numeric',
            'profit_loss'   => 'required|numeric',
            'status'        => 'required|in:pending,closed',
            'opened_at'     => 'nullable|date',
            'closed_at'     => 'nullable|date',
            'executed_at'   => 'required|date',
        ]);

        $validated['trader_id'] = $trader->id;

        Trade::create($validated);

        return redirect()->route('admin.traders.show', $trader)->with('success', 'Trade added successfully.');
    }
}
