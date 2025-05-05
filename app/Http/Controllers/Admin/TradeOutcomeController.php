<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trader;
use App\Models\TradeOutcome;
use Illuminate\Http\Request;

class TradeOutcomeController extends Controller
{
    public function index(Request $request)
    {
        $query = TradeOutcome::with('trader')->latest();

        if ($request->filled('trader_id')) {
            $query->where('trader_id', $request->trader_id);
        }

        $tradeOutcomes = $query->paginate(15);
        $traders = Trader::all();

        return view('admin.trade-outcomes.index', compact('tradeOutcomes', 'traders'));
    }

    public function create()
    {
        $traders = Trader::all();
        return view('admin.trade-outcomes.create', compact('traders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trader_id' => 'required|exists:traders,id',
            'percentage' => 'required|numeric',
            'description' => 'nullable|string|max:1000',
        ]);

        TradeOutcome::create([
            'trader_id' => $request->trader_id,
            'percentage' => $request->percentage,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.tradeOutcomes.index')
            ->with('success', 'Trade outcome recorded successfully.');
    }
}
