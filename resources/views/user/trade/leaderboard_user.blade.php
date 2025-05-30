<x-layouts.app>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Trader Leaderboard</h1>

    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or ID"
                class="input input-bordered w-full" />
        </div>
        <div>
            <input type="number" step="0.01" name="min_roi" value="{{ request('min_roi') }}" placeholder="Min ROI (%)"
                class="input input-bordered w-full" />
        </div>
        <div>
            <input type="number" step="0.01" name="min_win_rate" value="{{ request('min_win_rate') }}" placeholder="Min Win Rate (%)"
                class="input input-bordered w-full" />
        </div>
        <div>
            <select name="sort" class="select select-bordered w-full">
                <option value="roi" {{ request('sort') == 'roi' ? 'selected' : '' }}>Sort by ROI</option>
                <option value="win_rate" {{ request('sort') == 'win_rate' ? 'selected' : '' }}>Sort by Win Rate</option>
                <option value="subscribers" {{ request('sort') == 'subscribers' ? 'selected' : '' }}>Sort by Subscribers</option>
                <option value="total_trades" {{ request('sort') == 'total_trades' ? 'selected' : '' }}>Sort by Total Trades</option>
                <option value="avg_return_per_trade" {{ request('sort') == 'avg_return_per_trade' ? 'selected' : '' }}>Sort by Avg Return/Trade</option>
            </select>
        </div>
        <div>
            <select name="direction" class="select select-bordered w-full">
                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary w-full">Filter & Sort</button>
            <a href="{{ route('user.leaderboard') }}" class="btn btn-secondary w-full mt-2 md:mt-0">Reset</a>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="table w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-3 py-2 text-left">Trader Name</th>
                    <th class="border border-gray-300 px-3 py-2 text-left">Trader ID</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">ROI (%)</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">Win Rate (%)</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">Subscribers</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">Total Trades</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($traders as $trader)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-3 py-2">
                            <a href="{{ route('guests.trader-profile', $trader->id) }}" class="text-blue-600 hover:underline">
                                {{ $trader->name }}
                            </a>
                        </td>
                        <td class="border border-gray-300 px-3 py-2">
                            <a href="{{ route('guests.trader-profile', $trader->id) }}" class="text-blue-600 hover:underline">
                                {{ $trader->trader_id }}
                            </a>
                        </td>
                        <td class="border border-gray-300 px-3 py-2 text-right">{{ number_format($trader->roi, 2) }}%</td>
                        <td class="border border-gray-300 px-3 py-2 text-right">{{ number_format($trader->win_rate, 2) }}%</td>
                        <td class="border border-gray-300 px-3 py-2 text-right">{{ $trader->subscriptions_count }}</td>
                        <td class="border border-gray-300 px-3 py-2 text-right">{{ $trader->trades_count }}</td>
                        <td class="border border-gray-300 px-3 py-2 text-center space-x-2">
                            @if (!$user->subscriptions->contains('trader_id', $trader->id))
                                <a href="{{ route('user.subscribe', $trader->id) }}" class="btn btn-sm btn-primary">
                                    Copy Trader
                                </a>
                            @else
                                <span class="badge badge-success">Subscribed</span>
                            @endif

                            <form method="POST" action="{{ route('user.traders.addToCompare', $trader->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-secondary">Add to Compare</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">No traders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $traders->links() }}
    </div>

    <a href="{{ route('user.leaderboard', array_merge(request()->query(), ['export' => 1])) }}" class="btn btn-success mt-4">
        Export CSV
    </a>

    <a href="{{ route('user.traders.compare') }}" class="btn btn-info mt-2">
        Compare Selected Traders
    </a>
</div>
</x-layouts.app>
