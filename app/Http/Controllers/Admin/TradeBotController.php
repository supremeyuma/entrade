<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trader;


class TradeBotController extends Controller
{
    
    public function index()
    {
        return view('admin.trade-bot.index', [
            'markets' => ['forex', 'crypto', 'stocks', 'indices'],
            'traders' => Trader::all(),
        ]);
    }

    public function run(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'roi' => 'required|numeric|min:1',
            'markets' => 'required|array',
            'trading_pairs' => 'required|array',
            'assign_to' => 'nullable|exists:traders,id',
            'auto_run' => 'nullable|boolean',
        ]);

        // Save config to DB (optional)
        $config = TradeBotConfig::create($validated);

        // Immediately dispatch generation logic
        dispatch(new GenerateHistoricalTradesJob($config));

        // If future-dated, schedule job periodically
        if ($validated['start_date'] > now()) {
            dispatch(new GenerateFutureTradesJob($config));
        }

        return redirect()->route('admin.trade-bot.index')->with('success', 'Trade generation started!');
    }

    public function results()
    {
        return view('admin.trade-bot.results', [
            'trades' => Trade::where('source', 'bot')->latest()->paginate(50),
        ]);
    }

}
