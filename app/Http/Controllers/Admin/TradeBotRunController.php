<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradeBotRun;
use Illuminate\Http\Request;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TradeBotRunController extends Controller
{
    public function index(Request $request)
    {
        $query = Trade::query()
            ->select([
                'batch_id',
                'trader_id',
                DB::raw('COUNT(*) as trade_count'),
                DB::raw('AVG(roi) as average_roi'),
                DB::raw('SUM(CASE WHEN roi > 0 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as win_rate'),
                DB::raw('MIN(entry_timestamp) as from_date'),
                DB::raw('MAX(exit_timestamp) as to_date'),
            ])
            ->whereNotNull('batch_id')
            ->groupBy('batch_id', 'trader_id');

        // Optional filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('trader', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('entry_timestamp', [$request->from, $request->to]);
        }

        $query->orderByDesc('from_date');

        $batches = $query->paginate(15);

        return view('admin.trades.simulated_batches.index', compact('batches'));
    }

    public function show($batchId)
    {
        $trades = Trade::where('batch_id', $batchId)->get();

        return view('admin.trades.simulated_batches.show', compact('trades', 'batchId'));
    }


    public function rerun(TradeBotConfig $config)
    {
        // Create new run entry
        $run = TradeBotRun::create([
            'trade_bot_config_id' => $config->id,
            'status' => 'pending',
            'result_summary' => null,
        ]);

        // Dispatch to job or run inline
        SimulateTradesForRun::dispatchSync($run); // or use dispatch() for async

        return back()->with('success', 'TradeBotConfig has been re-run successfully.');
    }


}

