<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\TradeHistory;
use App\Models\Trader;
use App\Http\Controllers\Controller;

class TradeHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = TradeHistory::where('user_id', $user->id);
            //->with('trader', 'tradeOutcome')
        

         if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('trader_id')) {
            $query->where('trader_id', $request->trader_id);
        }

        $histories = $query->latest()->paginate(20);
        $traders = Trader::orderBy('name')->get();


        return view('user.trade.history', compact('histories', 'traders'));
    }

    public function export(Request $request)
    {
        $query = TradeHistory::with('trader');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('trader_id')) {
            $query->where('trader_id', $request->trader_id);
        }

        $histories = $query->get();

        $csv = Writer::createFromString('');
        $csv->insertOne(['Date', 'Trader', 'ROI (%)', 'Profit/Loss', 'Prev Balance', 'New Balance']);

        foreach ($histories as $history) {
            $csv->insertOne([
                $history->created_at->format('Y-m-d H:i'),
                $history->trader->name,
                $history->roi,
                $history->profit_loss_amount,
                $history->amount_invested,
                $history->amount_returned,
            ]);
        }

        return response((string) $csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="trade_history.csv"');
    }

}
