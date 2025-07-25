<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradeBotRun;

class TradeBotRunController extends Controller
{
    public function index()
    {
        $runs = TradeBotRun::with('config')
            ->latest()
            ->paginate(20);

        return view('admin.trade_bot.runs.index', compact('runs'));
    }
}

