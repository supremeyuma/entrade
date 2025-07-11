<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TraderController extends Controller
{
    public function index()
    {
        $traders = Trader::all();
        return view('admin.traders.index', compact('traders'));
    }

    public function create()
    {
        return view('admin.traders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'performance_metrics' => 'nullable|json',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'bio', 'performance_metrics');

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('traders', 'public');
        }

        Trader::create($data);

        ActivityLogger::log('add_trader', 'Added new trader: ' . $trader->name . ' (ID: ' . $trader->id . ')', auth()->id());


        return redirect()->route('admin.traders.index')->with('success', 'Trader created successfully.');
    }

    public function edit(Trader $trader)
    {
        return view('admin.traders.edit', compact('trader'));
    }

    public function update(Request $request, Trader $trader)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'performance_metrics' => 'nullable|json',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'bio', 'performance_metrics');

        if ($request->hasFile('profile_photo')) {
            if ($trader->profile_photo) {
                Storage::disk('public')->delete($trader->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('traders', 'public');
        }

        $trader->update($data);

        ActivityLogger::log('update_trader', 'Updated trader: ' . $trader->name . ' (ID: ' . $trader->id . ')', auth()->id());


        return redirect()->route('admin.traders.index')->with('success', 'Trader updated successfully.');
    }

    public function show(Trader $trader)
    {
        $trader->load('trades');
        return view('admin.traders.show', compact('trader'));
    }


    public function destroy(Trader $trader)
    {
        if ($trader->profile_photo) {
            Storage::disk('public')->delete($trader->profile_photo);
        }
        $trader->delete();
        return redirect()->route('admin.traders.index')->with('success', 'Trader deleted successfully.');
    }

    public function subscribers(Trader $trader)
    {
        $subscribers = $trader->subscriptions()->with('user')->paginate(20);
        return view('admin.traders.subscribers', compact('trader', 'subscribers'));
    }

}
