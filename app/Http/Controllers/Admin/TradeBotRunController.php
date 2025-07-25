<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradeBotRun;

class TradeBotRunController extends Controller
{
    public function index(Request $request)
    {
        $query = TradeBotRun::query()->with('config', 'config.trader');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('config', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('market_type', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        if ($request->filled('sort')) {
            $sort = match ($request->sort) {
                'oldest' => ['created_at', 'asc'],
                'roi' => ['config->roi_target', 'desc'],
                default => ['created_at', 'desc'],
            };
            $query->orderBy(...$sort);
        }

        $runs = $query->paginate(15);

        return view('admin.trade_bot.runs.index', compact('runs'));
    }

}

