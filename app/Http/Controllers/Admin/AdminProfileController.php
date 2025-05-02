<?php



namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user(); // Get the current logged-in user
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $user = Auth::user();
        $user->update($request->all());

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully!');
    }
}
