<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BotLog;

class BotController extends Controller
{
    public function index()
    {
        $logs = BotLog::with('trader')->latest()->paginate(20);
        return view('admin.bot_logs.index', compact('logs'));
    }

}
