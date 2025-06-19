<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

class MarketController extends Controller
{
    public function index()
    {
        return view('guests.markets');
    }
}
