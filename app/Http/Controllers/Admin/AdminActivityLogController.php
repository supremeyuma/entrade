<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->when($request->input('user_id'), fn($q) => $q->where('user_id', $request->input('user_id')))
            ->when($request->input('action_type'), fn($q) => $q->where('action_type', $request->input('action_type')))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.activity-logs.index', compact('logs'));
    }
}
