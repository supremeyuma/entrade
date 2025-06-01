<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Deposit, Withdrawal, Trade, Referral};
use PDF;
use Auth;
use App\Services\SiteSettingsService;

class UserReportController extends Controller
{   
    protected SiteSettingsService $settingsService;

    public function __construct(SiteSettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function showReportOptions()
    {
        $settings = $this->settingsService->get([
            'user_reports_enable_deposits',
            'user_reports_enable_withdrawals',
            'user_reports_enable_trades',
            'user_reports_enable_referrals',
        ]);

        return view('user.reports.index', compact('settings'));
    }

    public function generateReport(Request $request)
    {
        $user = Auth::user();
        $sections = $request->input('sections', ['all']);
        $data = [];

        if (in_array('all', $sections) || in_array('deposits', $sections)) {
            $data['deposits'] = Deposit::where('user_id', $user->id)->get();
        }
        if (in_array('all', $sections) || in_array('withdrawals', $sections)) {
            $data['withdrawals'] = Withdrawal::where('user_id', $user->id)->get();
        }
        if (in_array('all', $sections) || in_array('trades', $sections)) {
            $data['trades'] = Trade::where('user_id', $user->id)->get();
        }
        if (in_array('all', $sections) || in_array('referrals', $sections)) {
            $data['referrals'] = Referral::where('referrer_id', $user->id)->get();
        }

        $pdf = PDF::loadView('user.reports.pdf', [
            'data' => $data,
            'user' => $user,
        ]);

        return $pdf->download('user_report_' . now()->format('Ymd_His') . '.pdf');
    }
}
