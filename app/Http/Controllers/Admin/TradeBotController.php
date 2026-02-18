<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trader;
use App\Models\User;
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
        // Provide markets and eligible users (exclude users with roles 'admin' or 'trader')
        $eligibleUsers = User::whereDoesntHave('roles', function ($q) {
            $q->whereIn('name', ['admin', 'trader']);
        })->get();

        return view('admin.trade_bot.index', [
            'users' => $eligibleUsers,
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
        // Preview simulation removed per new requirements.
        abort(404);
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
            'end_date' => 'required|date|after_or_equal:start_date',
            // CHANGED to nullable|string for single textarea input
            'trading_pairs' => 'nullable|string',
            'assign_to' => 'nullable|exists:traders,id',
            'auto_run' => 'nullable|boolean',
            'timeframe' => 'required|in:1min,5min,15min,30min,60min,1d',
            'risk_per_trade' => 'required|numeric|min:0|max:100',
            'desired_win_rate' => 'nullable|numeric|min:0|max:100',
            'max_trades' => 'nullable|integer|min:1',
            'export_csv' => 'nullable|boolean',
            'min_trade_duration_days' => 'required|integer|min:1',
            'max_trade_duration_days' => 'required|integer|min:1|gte:min_trade_duration_days',
        ]);

        // --- Process trading_pairs into a clean array of symbols ---
        $cleanTradingPairs = [];
        if (!empty($validated['trading_pairs'])){
            $commaSeparatedString = $validated['trading_pairs'];
            $cleanTradingPairs = array_map('trim', explode(',', $commaSeparatedString));
            $cleanTradingPairs = array_filter($cleanTradingPairs);
        }

        // Save configuration (without markets/roi fields — those were removed)
        $config = TradeBotConfig::create([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'trading_pairs' => $cleanTradingPairs,
            'assign_to' => $validated['assign_to'] ?? null,
            'auto_run' => $validated['auto_run'] ?? false,
            'timeframe' => $validated['timeframe'],
            'risk_per_trade' => $validated['risk_per_trade'],
            'desired_win_rate' => $validated['desired_win_rate'] ?? null,
            'max_trades' => $validated['max_trades'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('admin.trade-bot.index')
            ->with('success', 'Trade generation job started successfully.');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'trading_pairs' => 'nullable|string',
            'net_profit' => 'required|numeric',
            'desired_win_rate' => 'nullable|numeric|min:0|max:100',
            'max_trades' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
            'markets' => 'nullable|array',
        ]);

        // Ensure selected user is not admin or trader
        $user = User::find($validated['user_id']);
        if ($user->hasAnyRole(['admin', 'trader'])) {
            return back()->withErrors(['user_id' => 'Selected user is not eligible for synthetic trade generation.']);
        }

        // Process trading_pairs into array
        $cleanTradingPairs = [];
        if (!empty($validated['trading_pairs'])) {
            $cleanTradingPairs = array_filter(array_map('trim', explode(',', $validated['trading_pairs'])));
        }

        // Dispatch job to generate synthetic trades for the selected user
        GenerateSimulatedTradesJob::dispatch(
            tradingPairs: $cleanTradingPairs,
            netProfit: (float) $validated['net_profit'],
            targetWinRate: (float) ($validated['desired_win_rate'] ?? 50),
            tradeCount: (int) $validated['max_trades'],
            userId: (int) $validated['user_id'],
            startDate: $validated['start_date'],
            endDate: $validated['end_date'],
        );

        return back()->with('success', 'Synthetic trade generation job dispatched.');
    }

}