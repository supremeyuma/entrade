<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trader;
use App\Http\Controllers\Controller;

class TraderLeaderboardController extends Controller
{
    public function publicLeaderboard()
    {
        $traders = Trader::orderByDesc('roi')
            ->limit(5)
            ->get();

        return view('user.trade.leaderboard_public', compact('traders'));
    }

    public function userLeaderboard(Request $request)
    {
        $query = Trader::query();

        if ($request->filled('min_roi')) {
            $query->where('roi', '>=', $request->input('min_roi'));
        }

        if ($request->filled('min_win_rate')) {
            $query->where('win_rate', '>=', $request->input('min_win_rate'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('trader_id', 'LIKE', "%{$search}%");
            });
        }

        $sort = $request->input('sort', 'roi');
        $direction = $request->input('direction', 'desc');
        $allowedSorts = ['roi', 'win_rate', 'subscribers', 'total_trades', 'avg_return_per_trade'];

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        }
        // Optional CSV Export
        if ($request->has('export')) {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="leaderboard.csv"',
            ];
        
            $callback = function () use ($query) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Name', 'Trader ID', 'ROI', 'Win Rate', 'Subscribers', 'Total Trades', 'Avg Return/Trade']);
        
                foreach ($query->get() as $trader) {
                    fputcsv($handle, [
                        $trader->name,
                        $trader->trader_id,
                        $trader->roi,
                        $trader->win_rate,
                        $trader->subscribers,
                        $trader->total_trades,
                        $trader->avg_return_per_trade,
                    ]);
                }
        
                fclose($handle);
            };
        
            return response()->stream($callback, 200, $headers);
        }
        //End of Optional CSV Export
        

        $traders = $query->paginate(20)->appends($request->query());

        return view('user.trade.leaderboard_user', compact('traders'));
    }
}
