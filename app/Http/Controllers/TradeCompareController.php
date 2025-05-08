<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trader;

class TraderCompareController extends Controller
{
    public function addToCompare(Request $request, $traderId)
    {
        $compareList = session()->get('compare_traders', []);

        if (in_array($traderId, $compareList)) {
            return redirect()->back()->with('error', 'Trader already in compare list.');
        }

        if (count($compareList) >= 5) {
            return redirect()->back()->with('error', 'Maximum 5 traders can be compared at once.');
        }

        $compareList[] = $traderId;
        session(['compare_traders' => $compareList]);

        return redirect()->back()->with('success', 'Trader added to compare list.');
    }

    public function removeFromCompare(Request $request, $traderId)
    {
        $compareList = session()->get('compare_traders', []);

        $compareList = array_filter($compareList, fn($id) => $id != $traderId);

        session(['compare_traders' => $compareList]);

        return redirect()->back()->with('success', 'Trader removed from compare list.');
    }

    public function showCompare(Request $request)
    {
        $compareList = session()->get('compare_traders', []);

        if (empty($compareList)) {
            return view('user.trade.compare-empty');
        }

        $traders = Trader::whereIn('id', $compareList)->get();

        // Example sample ROI history (replace with real data logic)
        $chartData = [];
        foreach ($traders as $trader) {
            $chartData[] = [
                'label' => $trader->name,
                'data' => [10, 15, 20, 18, 22], // Replace with actual ROI data
                'borderColor' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'fill' => false
            ];
        }

        return view('user.trade.compare', compact('traders', 'chartData'));
    }
}
