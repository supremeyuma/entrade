<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\Trader;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function index()
    {
        $trades = Trade::orderBy('created_at', 'desc')->get();

        return view('admin.trades.index', compact('trades'));
    }


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
    
    public function edit(Trade $trade)
    {
        return view('admin.trades.edit', compact('trade'));
    }

    public function update(Request $request, Trade $trade)
    {
        $data = $request->validate([
            'asset' => 'required|string',
            'trade_type' => 'required|string',
            'entry_price' => 'nullable|numeric',
            'exit_price' => 'nullable|numeric',
            'profit_loss' => 'nullable|numeric',
            'status' => 'nullable|string',
            'executed_at' => 'nullable|date',
        ]);

        $trade->update($data);

        return redirect()->route('admin.traders.show', $trade->trader_id)
            ->with('success', 'Trade updated successfully.');
    }

    public function destroy(Trade $trade)
    {
        $traderId = $trade->trader_id;
        $trade->delete();

        return redirect()->route('admin.traders.show', $traderId)
            ->with('success', 'Trade deleted.');
    }

}
