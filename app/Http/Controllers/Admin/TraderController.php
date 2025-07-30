<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TraderController extends Controller
{
    public function index(Request $request)
    {
        $query = Trader::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%");
        }

        // Sort
        if ($sort = $request->input('sort')) {
            if ($sort === 'roi') {
                $query->orderByRaw("JSON_EXTRACT(performance_metrics, '$.roi') DESC");
            } elseif ($sort === 'trades') {
                $query->withCount('trades')->orderBy('trades_count', 'desc');
            } else {
                $query->orderBy('name');
            }
        } else {
            $query->orderBy('name');
        }

        $traders = $query->paginate(10)->withQueryString();
        
        
        foreach ($traders as $trader) {
        $average_roi = round($trader->trades->avg('roi') ?? 0, 2);
        
        
            $totalTrades = $trader->trades->count();
            $winningTrades = $trader->trades->filter(fn ($trade) =>$trade->roi > 0)->count();
            $winRate = round($winningTrades / $totalTrades * 100, 2);
        }

        return view('admin.traders.index', compact('traders', 'winRate', 'average_roi'));
    }


    public function create()
    {
        return view('admin.traders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|image|max:2048',
            'performance' => 'nullable|array',
        ]);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('traders', 'public');
        }

        $validated['performance_metrics'] = $validated['performance'] ?? [];
        unset($validated['performance']);

        $trader = Trader::create($validated);

        ActivityLogger::log(
            'add_trader',
            'Added new trader: ' . $trader->name . ' (ID: ' . $trader->id . ')',
            auth()->id()
        );

        return redirect()->route('admin.traders.index')->with('success', 'Trader created successfully.');
    }


    public function edit(Trader $trader)
    {
        return view('admin.traders.edit', compact('trader'));
    }

    public function update(Request $request, Trader $trader)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|image|max:2048',
            'performance' => 'nullable|array',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($trader->profile_photo) {
                Storage::disk('public')->delete($trader->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('traders', 'public');
        }

        $validated['performance_metrics'] = $validated['performance'] ?? [];
        unset($validated['performance']);

        $trader->update($validated);

        ActivityLogger::log(
            'update_trader',
            'Updated trader: ' . $trader->name . ' (ID: ' . $trader->id . ')',
            auth()->id()
        );

        return redirect()->route('admin.traders.index')->with('success', 'Trader updated successfully.');
    }


    public function show(Trader $trader)
    {
        $trader->load('trades');
            // Paginate trades
        $trades = $trader->trades()->latest()->paginate(20);

        // Monthly ROI (e.g. Jan-Dec)
         $range = request('range', '12m'); // Default to 12 months
        $now = \Carbon\Carbon::now();

        $labels = [];
        $roiData = [];

        if ($range === '1w') {
            $days = collect(range(0, 6))->map(fn($i) => $now->copy()->subDays($i))->reverse();

            $labels = $days->map(fn($d) => $d->format('D d M'))->values()->all();
            $roiData = $days->map(function ($day) use ($trader) {
                return round($trader->trades
                    ->filter(fn($t) => \Carbon\Carbon::parse($t->exit_timestamp)->isSameDay($day))
                    ->avg('roi') ?? 0, 2);
            });

        } else {
            // Interpret range (e.g. "3m", "6m", "12m", "24m")
            $months = match ($range) {
                '3m' => 3,
                '6m' => 6,
                '24m' => 24,
                default => 12
            };

            $monthDates = collect(range(0, $months - 1))
                ->map(fn($i) => $now->copy()->subMonths($i))
                ->reverse();

            $labels = $monthDates->map(fn($d) => $d->format('M Y'))->values()->all();
            $roiData = $monthDates->map(function ($month) use ($trader) {
                $avgRoi = $trader->trades
                    ->filter(fn($t) => \Carbon\Carbon::parse($t->exit_timestamp)->format('Y-m') === $month->format('Y-m'))
                    ->avg('roi');

                return round($avgRoi ?? 0, 2);
            }) ->values()->all();
        }
        

        // Count subscribers
        $subscriberCount = $trader->subscriptions()->count(); // assumes Trader has 'subscribers()' relationship
        $average_roi = round($trader->trades->avg('roi') ?? 0, 2);
        
        $totalTrades = $trader->trades->count();
        $winningTrades = $trader->trades->filter(fn ($trade) =>$trade->roi > 0)->count();

        $winRate = round($winningTrades / $totalTrades * 100, 2);
    return view('admin.traders.show', compact('trader', 'trades', 'roiData', 'labels', 'subscriberCount', 'average_roi', 'winRate'));

    }

    public function toggleActive(Trader $trader)
    {
        $trader->is_active = !$trader->is_active;
        $trader->save();

        return back()->with('success', 'Trader status updated.');
    }

    public function toggleFeatured(Trader $trader)
    {
        $trader->is_featured = !$trader->is_featured;
        $trader->save();

        return back()->with('success', 'Trader featured status updated.');
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
