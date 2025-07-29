<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TradeHistory;

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

    public function tradeHistory(User $user)
    {
        $tradeHistories = TradeHistory::with(['trade', 'trade.trader'])
            ->where('user_id', $user->id)
            ->join('trades', 'trade_histories.trade_id', '=', 'trades.id')
            ->orderBy('trades.entry_timestamp', 'desc')
            ->select('trade_histories.*') // Important to avoid column conflicts
            ->paginate(20);

        return view('admin.users.trade_histories', compact('user', 'tradeHistories'));
    }


}
