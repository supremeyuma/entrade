<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TradeLogController extends Controller
{
    public function index()
    {
        return view('admin.trade_logs.index');
    }
}
