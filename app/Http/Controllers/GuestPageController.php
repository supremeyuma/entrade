<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Trader;

class GuestPageController extends Controller
{
    public function home(Request $request)
    {
        $query = Trader::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                    ->orWhere('trader_id', 'like', "%{$search}%");
        }

        if ($minRoi = $request->input('min_roi')) {
            $query->where('roi', '>=', $minRoi);
        }

        if ($minWinRate = $request->input('min_win_rate')) {
            $query->where('win_rate', '>=', $minWinRate);
        }

        // Sorting
        $sort = $request->input('sort', 'roi');
        $direction = $request->input('direction', 'desc');

        if (in_array($sort, ['roi', 'win_rate', 'subscriptions_count', 'total_trades', 'avg_return_per_trade'])) {
            $query->orderBy($sort, $direction);
        }

        // Load counts for subscribers and trades
        $query->withCount(['subscriptions', 'trades']);

        // Pagination
        $topTraders = $query->paginate(15)->withQueryString();

        $user = Auth::user();

        return view('guests.home', compact('topTraders', 'user'));
        
    }
}
