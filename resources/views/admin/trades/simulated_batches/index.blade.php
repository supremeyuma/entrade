<x-layouts.admin>
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 sm:py-10 lg:px-8">
        <h1 class="mb-4 text-xl font-bold sm:mb-6 sm:text-2xl">Simulated Trade Batches</h1>

        <form method="GET" class="mb-4 flex flex-wrap items-end gap-3 sm:gap-4">
            <input name="search" value="{{ request('search') }}" type="text" class="input input-bordered" placeholder="Search by trader">
            <input name="from" value="{{ request('from') }}" type="date" class="input input-bordered">
            <input name="to" value="{{ request('to') }}" type="date" class="input input-bordered">
            <button class="btn btn-indigo" type="submit">Filter</button>
        </form>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">Batch ID</th>
                        <th class="px-4 py-3">Trader</th>
                        <th class="px-4 py-3">Trades</th>
                        <th class="px-4 py-3">Avg ROI</th>
                        <th class="px-4 py-3">Win Rate</th>
                        <th class="px-4 py-3">From</th>
                        <th class="px-4 py-3">To</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-100">
                    @forelse ($batches as $batch)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2 text-xs font-mono text-blue-600">{{ $batch->batch_id }}</td>
                            <td class="px-4 py-2">{{ optional($batch->trader)->name ?? 'Unknown' }}</td>
                            <td class="px-4 py-2">{{ $batch->trade_count }}</td>
                            <td class="px-4 py-2">{{ number_format($batch->average_roi, 2) }}%</td>
                            <td class="px-4 py-2">{{ number_format($batch->win_rate, 2) }}%</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($batch->from_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($batch->to_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.trade-bot.show', $batch->batch_id) }}" class="text-blue-500 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500">No simulated trade batches found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $batches->links() }}
        </div>
    </div>
</x-layouts.admin>
