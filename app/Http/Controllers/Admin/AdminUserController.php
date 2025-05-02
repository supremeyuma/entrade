<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;   

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
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
}
