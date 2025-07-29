<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradeLog;
use App\Models\Trader;
use App\Models\Trade;
use Illuminate\Http\Request;

class TradeLogController extends Controller
{
    public function index()
    {
        $tradeLogs = TradeLog::with('trader')->latest()->get();
        //$trades = Trade::where('trader_id', $traderId)
        //    ->orderBy('opened_at', 'desc')
        //    ->get();

        return view('admin.trade-logs.index', compact('tradeLogs'));
    }

    public function create()
    {
        $traders = Trader::all();
        return view('admin.trade-logs.create', compact('traders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trader_id' => 'required|exists:traders,id',
            'entry_date' => 'required|date',
            'result' => 'required|in:win,loss',
            'percentage_change' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        TradeLog::create($request->all());

        return redirect()->route('admin.trade-logs.index')->with('success', 'Trade log created successfully.');
    }

    public function edit(TradeLog $tradeLog)
    {
        $traders = Trader::all();
        return view('admin.trade-logs.edit', compact('tradeLog', 'traders'));
    }

    public function update(Request $request, TradeLog $tradeLog)
    {
        $request->validate([
            'trader_id' => 'required|exists:traders,id',
            'entry_date' => 'required|date',
            'result' => 'required|in:win,loss',
            'percentage_change' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        $tradeLog->update($request->all());

        return redirect()->route('admin.trade-logs.index')->with('success', 'Trade log updated successfully.');
    }

    public function destroy(TradeLog $tradeLog)
    {
        $tradeLog->delete();
        return redirect()->route('admin.trade-logs.index')->with('success', 'Trade log deleted.');
    }
}
