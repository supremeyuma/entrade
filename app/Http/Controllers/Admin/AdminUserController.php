<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TradeHistory;
use App\Models\Trader;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('balance'); // assuming Balance relationship exists
        $transactions = $user->transactions()->latest()->get();

        return view('admin.users.show', compact('user', 'transactions'));
    }
    
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:users,email,' . $user->id,
            'role'   => 'required|in:user,trader,admin',
            'status' => 'nullable|string|max:50',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully.');
    }


    public function editRole(User $user)
    {
        $roles = Role::pluck('name', 'id');
        return view('admin.users.edit-role', compact('user', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,id',
        ]);

        // Remove current roles and assign the new one
        $role = Role::findById($request->role);
        $user->syncRoles([$role]);

        return redirect()->route('admin.users.index')->with('success', 'Role updated successfully.');
    }

    public function tradeHistory(Request $request, User $user)
    {
        /*$tradeHistories = TradeHistory::with(['trade', 'trade.trader'])
            ->where('user_id', $user->id)
            //->join('trades', 'trade_histories.trade_id', '=', 'trades.id')
            ->orderBy('created_at', 'desc')
            ->select('trade_histories.*') // Important to avoid column conflicts
            ->paginate(20);
        //$traderName = Trader::where('user_id', $tradeHistories->first()->first()?->name;*/


        // Fetch all traders for the filter dropdown
        $traders = Trader::orderBy('name')->get();

        // Start with the base query for the user
        $query = TradeHistory::with('trader')
            ->where('user_id', $user->id);

        // --- Add Filtering Logic ---
        if ($request->filled('trader_id')) {
            $query->where('trader_id', $request->trader_id);
        }

        // --- Add Sorting Logic ---
        $sortBy = $request->get('sort_by', 'created_at'); // Default sort column
        $sortDirection = $request->get('direction', 'desc'); // Default sort direction

        // Validate the sortable columns to prevent SQL injection
        $allowedSortColumns = ['id', 'created_at', 'roi', 'amount_invested', 'amount_returned', 'new_trade_balance'];
        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            // Fallback to default if the column is not allowed
            $query->orderBy('created_at', 'desc');
        }

        // Paginate the results and append the sorting/filtering parameters
        $tradeHistories = $query->paginate(20)->withQueryString();

            return view('admin.users.trade_histories', compact('user', 'tradeHistories', 'traders', 'sortBy', 'sortDirection'));
        }


}
