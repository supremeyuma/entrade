<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use App\Helpers\ActivityLogger;

class AdminDepositController extends Controller
{
    public function index(Request $request)
    {
        $query = Deposit::with('user');

        // Search by user name, email or invoice_id
        if ($q = $request->input('q')) {
            $query->whereHas('user', fn($q2) => $q2->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"))
                  ->orWhere('invoice_id', 'like', "%{$q}%");
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        } else {
            // By default hide old unpaid (waiting) deposits older than 72 hours
            $cutoff = Carbon::now()->subHours(72);
            $query->where(function($q2) use ($cutoff) {
                $q2->where('status', '!=', 'waiting')
                   ->orWhere('created_at', '>=', $cutoff);
            });
        }

        if ($from = $request->input('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        // Sorting
        $sort = $request->input('sort');
        if ($sort === 'amount_asc') {
            $query->orderBy('amount');
        } elseif ($sort === 'amount_desc') {
            $query->orderByDesc('amount');
        } elseif ($sort === 'date_asc') {
            $query->orderBy('created_at');
        } else {
            // default newest first
            $query->orderByDesc('created_at');
        }

        $deposits = $query->paginate(25)->withQueryString();

        return view('admin.deposits.index', compact('deposits'));
    }

    public function show($id)
    {
        $deposit = Deposit::with('user')->findOrFail($id);
        return view('admin.deposits.show', compact('deposit'));
    }

    public function approve(Request $request, $id)
    {
        $deposit = Deposit::with('user')->findOrFail($id);

        if ($deposit->status === 'finished') {
            return back()->with('error', 'Deposit already approved.');
        }

        $validated = $request->validate([
            'received_amount' => 'nullable|numeric|min:0',
            'admin_comment' => 'nullable|string|max:1000',
        ]);

        $received = $validated['received_amount'] ?? $deposit->amount;

        $deposit->received_amount = $received;
        $deposit->admin_comment = $validated['admin_comment'] ?? null;
        $deposit->status = 'finished';
        $deposit->save();

        // Credit user if not already credited
        if (!$deposit->user) {
            return back()->with('error', 'Deposit user not found.');
        }

        if (!isset($deposit->credited) || !$deposit->credited) {
            $balance = $deposit->user->balance;
            if ($balance) {
                $balance->main_balance = floatval($balance->main_balance ?? 0) + floatval($received);
                $balance->save();
            } else {
                // create balance record if missing
                $deposit->user->balance()->create([
                    'main_balance' => floatval($received),
                    'trade_balance' => 0,
                ]);
            }

            // mark as credited flag if column exists
            if (Schema::hasColumn('deposits', 'credited')) {
                $deposit->credited = true;
                $deposit->save();
            }
        }

        ActivityLogger::log('deposit_approved', "Approved deposit {$deposit->id} (invoice: {$deposit->invoice_id})", auth()->id());

        return redirect()->route('admin.deposits.index')->with('success', 'Deposit approved and user credited.');
    }

    public function reject(Request $request, $id)
    {
        $deposit = Deposit::with('user')->findOrFail($id);

        if ($deposit->status !== 'waiting' && $deposit->status !== 'pending') {
            return back()->with('error', 'This deposit request cannot be rejected.');
        }

        $validated = $request->validate([
            'admin_comment' => 'nullable|string|max:1000',
        ]);

        $deposit->status = 'rejected';
        $deposit->admin_comment = $validated['admin_comment'] ?? null;
        $deposit->save();

        ActivityLogger::log('deposit_rejected', "Rejected deposit {$deposit->id} (invoice: {$deposit->invoice_id})", auth()->id());

        return redirect()->route('admin.deposits.index')->with('success', 'Deposit rejected.');
    }
}
