<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trader;
use App\Models\TradeBotConfig;
use App\Jobs\GenerateHistoricalTradesJob; // Correctly referencing the new job
use App\Models\Trade;
use Illuminate\Support\Facades\Validator;
use App\Services\TradeBot\BacktestSimulator;
use Illuminate\Support\Facades\Log; // Added for potential debugging
use App\Jobs\GenerateSimulatedTradesJob; // Correctly referencing the new job

class TradeBotController extends Controller
{

    private function generateEquityCurve(array $trades): array
    {
        $equity = 100; // Starting equity
        $curve = [];

        foreach ($trades as $trade) {
            $equity += $equity * ($trade['roi'] / 100);
            $curve[] = [
                'timestamp' => $trade['timestamp'],
                'equity' => round($equity, 2),
            ];
        }

        return $curve;
    }

    public function index()
    {
        return view('admin.trade_bot.index', [
            'markets' => ['forex', 'crypto', 'stocks', 'indices'],
            'traders' => Trader::all(),
        ]);
    }

    public function run(Request $request)
    {
        // This 'run' method seems to be a duplicate or old logic.
        // Your 'store' method is what's actually saving the config and dispatching the job.
        // I'll assume 'store' is the primary method for this action.
        // If 'run' is also used, apply the same logic as 'store'.

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'roi' => 'required|numeric|min:1',
            'markets' => 'required|array',
            'trading_pairs' => 'nullable|string',
            'assign_to' => 'nullable|exists:traders,id',
            'auto_run' => 'nullable|boolean',
            //'timeframe' => 'required|in:1h,4h,1d',
            //'risk_per_trade' => 'required|numeric|min:0|max:100',
            'desired_win_rate' => 'nullable|numeric|min:0|max:100',
            'max_trades' => 'nullable|integer|min:1',
        ]);

        // --- FIX: Process trading_pairs into a clean array of symbols ---
        $cleanTradingPairs = [];
        if (!empty($validated['trading_pairs'])) {
            $commaSeparatedString = $validated['trading_pairs'][0] ?? '';
            $cleanTradingPairs = array_map('trim', explode(',', $commaSeparatedString));
            $cleanTradingPairs = array_filter($cleanTradingPairs);
        }
        // --- END FIX ---

        //INITIATE VARIABLES
        $timeframe = '1d';
        $risk_per_trade = 70; 

        // Save configuration
        $config = TradeBotConfig::create([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'roi' => $validated['roi'],
            'markets' => $validated['markets'],
            'trading_pairs' => $cleanTradingPairs,
            'assign_to' => $validated['assign_to'] ?? null,
            'auto_run' => $validated['auto_run'] ?? false,
            'timeframe' => $timeframe,
            'risk_per_trade' => $risk_per_trade,
            'desired_win_rate' => $validated['desired_win_rate'] ?? null,
            'max_trades' => $validated['max_trades'] ?? null,
            'status' => 'pending',
        ]);

        // --- FIX: Dispatch GenerateTradesJob with individual parameters from $config ---
        // Note: 'markets' is an array, but GenerateTradesJob expects a single market string.
        // You'll need to decide how to handle this. For now, I'll pick the first market.
        // If you need to simulate for EACH market, you'd loop here and dispatch multiple jobs.
        dispatch(new GenerateHistoricalTradesJob(
            $config->assign_to,
            $config->markets[0] ?? 'forex', // Assuming markets is an array, pick the first one or default
            $config->roi,
            $config->start_date,
            $config->end_date,
            $config->timeframe,
            $config->risk_per_trade,
            $config->desired_win_rate,
            $config->trading_pairs,
            $config->max_trades
        ));
        // --- END FIX ---

        // Optionally schedule future trades (if start date is in the future)
        if ($validated['start_date'] > now()) {
            // You may later implement GenerateFutureTradesJob
            // dispatch(new GenerateFutureTradesJob($config));
        }

        return redirect()->route('admin.trade-bot.index')
            ->with('success', 'Trade generation started!');
    }


    public function preview(Request $request, $id)
    {
        $tradeBotConfig = TradeBotConfig::findOrFail($id);

        // Run backtest simulation
        // Ensure BacktestSimulator::run expects these parameters and handles them correctly.
        // If BacktestSimulator needs the 'trading_pairs' array, make sure to pass it.
        $simulation = BacktestSimulator::run([
            'start_date' => $tradeBotConfig->start_date, // Use $tradeBotConfig
            'end_date' => $tradeBotConfig->end_date,     // Use $tradeBotConfig
            'timeframe' => $tradeBotConfig->timeframe ?? '1h',
            'risk_per_trade' => $tradeBotConfig->risk_per_trade ?? 1,
            'desired_win_rate' => $tradeBotConfig->desired_win_rate ?? 60,
            'max_trades' => $tradeBotConfig->max_trades ?? 100,
            // Add trading_pairs if BacktestSimulator needs it
            'trading_pairs' => $tradeBotConfig->trading_pairs, // Pass the array
        ]);

        return view('admin.trade_bot.preview', [
            'tradeBotConfig' => $tradeBotConfig,
            'roiCurve' => $simulation['roi_curve'] ?? [],
            'simulation' => $simulation,
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

    // Your second store method (duplicate, assuming this is the one you want to use)
    public function store(Request $request)
    {
       $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date', // Changed to after_or_equal for flexibility
            'roi' => 'required|numeric|min:1',
            'markets' => 'required|array',
            'markets.*' => 'in:forex,crypto,stocks', // Added validation for individual market values
            // CHANGED to nullable|string for single textarea input
            'trading_pairs' => 'nullable|string',
            'assign_to' => 'nullable|exists:traders,id',
            'auto_run' => 'nullable|boolean',
            'timeframe' => 'required|in:1min,5min,15min,30min,60min,1d',
            'risk_per_trade' => 'required|numeric|min:0|max:100',
            'desired_win_rate' => 'nullable|numeric|min:0|max:100',
            'max_trades' => 'nullable|integer|min:1',
            'export_csv' => 'nullable|boolean', // Added validation for export_csv
            'min_trade_duration_days' => 'required|integer|min:1',
            'max_trade_duration_days' => 'required|integer|min:1|gte:min_trade_duration_days',
        ]);

        // --- FIX: Process trading_pairs into a clean array of symbols ---
        $cleanTradingPairs = [];
        if (!empty($validated['trading_pairs'])){
            $commaSeparatedString = $validated['trading_pairs'];
            $cleanTradingPairs = array_map('trim', explode(',', $commaSeparatedString));
            $cleanTradingPairs = array_filter($cleanTradingPairs);
        }
        // --- END FIX ---

        // Save configuration
        $config = TradeBotConfig::create([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'roi' => $validated['roi'],
            'markets' => $validated['markets'],
            'trading_pairs' => $cleanTradingPairs,
            'assign_to' => $validated['assign_to'] ?? null,
            'auto_run' => $validated['auto_run'] ?? false,
            'timeframe' => $validated['timeframe'],
            'risk_per_trade' => $validated['risk_per_trade'],
            'desired_win_rate' => $validated['desired_win_rate'] ?? null,
            'max_trades' => $validated['max_trades'] ?? null,
            'status' => 'pending',
            //'export_csv' => $validated['export_csv'] ?? false,
        ]);

        // ... after you create the $config object
        // Save configuration
        $config = TradeBotConfig::create([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'roi' => $validated['roi'],
            'markets' => $validated['markets'],
            'trading_pairs' => $cleanTradingPairs,
            'assign_to' => $validated['assign_to'] ?? null,
            'auto_run' => $validated['auto_run'] ?? false,
            'timeframe' => $validated['timeframe'],
            'risk_per_trade' => $validated['risk_per_trade'],
            'desired_win_rate' => $validated['desired_win_rate'] ?? null,
            'max_trades' => $validated['max_trades'] ?? null,
            //'export_csv' => $validated['export_csv'] ?? false,
            'status' => 'pending',
        ]);

        // --- FIX: Pass the entire $config object to the job ---
        dispatch(new GenerateHistoricalTradesJob($config));
// --- END FIX ---

        return redirect()
            ->route('admin.trade-bot.index')
            ->with('success', 'Trade generation job started successfully.');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'symbol' => 'required|string',
            //'interval' => 'required|string',
            'market' => 'required|string',
            'roi' => 'required|numeric',
            'target_win_rate' => 'required|numeric',
            'max_trade_count' => 'required|integer',
            'trader_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'target_win_rate' => 'nullable|numeric',

        ]);

        $interval = $validated['interval'] ?? '1d'; // Default to '1d' if not provided

        GenerateSimulatedTradesJob::dispatch(
            symbol: $validated['symbol'],
            marketType: $validated['market'],
            interval: $interval,
            targetRoi: $validated['roi'],
            targetWinRate: $validated['target_win_rate'],
            tradeCount: $validated['max_trade_count'],
            traderUserId: $validated['trader_id'],
            startDate: $validated['start_date'],
            endDate: $validated['end_date'],
        );

        return back()->with('success', 'Simulation job dispatched.');
    }

}