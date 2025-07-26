<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trader;
use App\Models\TradeBotConfig;
use App\Jobs\GenerateHistoricalTradesJob;
use App\Models\Trade;
use Illuminate\Support\Facades\Validator;

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
            'timeframe' => 'required|in:1h,4h,1d',
            'risk_per_trade' => 'required|numeric|min:0|max:100',
            'desired_win_rate' => 'nullable|numeric|min:0|max:100',
            'max_trades' => 'nullable|integer|min:1',
        ]);

        // Save configuration
        $config = TradeBotConfig::create($validated);

        // Dispatch historical trade generation
        dispatch(new GenerateHistoricalTradesJob($config));

        // Optionally schedule future trades (if start date is in the future)
        if ($validated['start_date'] > now()) {
            // You may later implement GenerateFutureTradesJob
            // dispatch(new GenerateFutureTradesJob($config));
        }

        return redirect()->route('admin.trade-bot.index')
            ->with('success', 'Trade generation started!');
    }


    public function preview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'target_roi' => 'required|numeric|min:1|max:500',
            'symbol' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date',
            'strategy' => 'required|string',
            'timeframe' => 'required|in:1h,4h,1d',
            'risk_per_trade' => 'nullable|numeric|min:0|max:100',
            'desired_win_rate' => 'nullable|numeric|min:0|max:100',
            'max_trades' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input.'], 422);
        }

        $data = $validator->validated();

        // Simulated logic
        $totalCandles = match($data['timeframe']) {
            '1h' => (strtotime($data['to_date']) - strtotime($data['from_date'])) / 3600,
            '4h' => (strtotime($data['to_date']) - strtotime($data['from_date'])) / (3600 * 4),
            '1d' => (strtotime($data['to_date']) - strtotime($data['from_date'])) / (3600 * 24),
        };

        $baseTradeCount = floor($totalCandles / 15); // one trade every ~15 candles

        // Apply config caps
        $maxTrades = $data['max_trades'] ?? 500;
        $tradeCount = min($baseTradeCount, $maxTrades);

        // Simulated win rate and ROI
        $winRate = $data['desired_win_rate'] ?? rand(55, 85);
        $avgProfitPerTrade = ($data['target_roi'] / $tradeCount);

        return response()->json([
            'trade_count' => $tradeCount,
            'win_rate' => round($winRate, 2),
            'projected_roi' => round($avgProfitPerTrade * $tradeCount, 2),
        ]);
    }

    public function logs(TradeBotConfig $tradeBotConfig)
    {
        return response()->json([
            'job_log' => $tradeBotConfig->job_log
        ]);
    }


    public function results()
    {
        return view('admin.trade-bot.results', [
            'trades' => Trade::where('source', 'bot')->latest()->paginate(50),
        ]);
    }


}
