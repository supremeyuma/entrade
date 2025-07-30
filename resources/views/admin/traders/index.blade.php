<x-layouts.admin>
    <div class="px-4 py-6">
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
            <h1 class="text-2xl font-bold">Traders</h1>
            <a href="{{ route('admin.traders.create') }}" class="btn btn-primary">+ Add Trader</a>
        </div>

        {{-- Search + Sort --}}
        <form method="GET" class="flex flex-col md:flex-row items-center gap-4 mb-6">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search trader..." class="input w-full md:w-64">
            <select name="sort" class="input w-full md:w-52">
                <option value="">Sort by</option>
                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                <option value="roi" {{ request('sort') === 'roi' ? 'selected' : '' }}>ROI (High → Low)</option>
                <option value="trades" {{ request('sort') === 'trades' ? 'selected' : '' }}>Trade Count</option>
            </select>
            <button type="submit" class="btn btn-secondary">Apply</button>
        </form>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded">
            <table class="table-auto w-full text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">ROI</th>
                        <th class="px-4 py-2 text-left">Trades</th>
                        <th class="px-4 py-2 text-left">Win Rate</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($traders as $trader)
                        <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                        
                            <td class="px-4 py-3 font-medium">{{ $trader->name }}</td>
                            <td class="px-4 py-3">
                                    <div class="w-full">
                                        <div class="text-xs font-semibold mb-1">{{ $average_roi }}%</div>
                                    </div>
                            </td>
                            <td class="px-4 py-3">{{ $trader->trades->count() }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                {{ $winRate }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.traders.show', $trader) }}" class="btn btn-xs btn-secondary">View</a>
                                    <a href="{{ route('admin.traders.edit', $trader) }}" class="btn btn-xs btn-warning">Edit</a>
                                    <form action="{{ route('admin.traders.destroy', $trader) }}" method="POST"
                                          onsubmit="return confirm('Are you sure?')" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">No traders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $traders->links() }}
        </div>
    </div>
</x-layouts.admin>
