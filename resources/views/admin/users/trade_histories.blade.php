<x-layouts.admin>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            Trade History for {{ $user->name }} (User #{{ $user->id }})
        </h2>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-3">Trade ID</th>
                        <th class="px-4 py-3">Trader</th>
                        <th class="px-4 py-3">Amount Invested</th>
                        <th class="px-4 py-3">ROI (%)</th>
                        <th class="px-4 py-3">Amount Returned</th>
                        <th class="px-4 py-3">Opened</th>
                        <th class="px-4 py-3">Closed</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-100 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($tradeHistories as $history)
                        <tr>
                            <td class="px-4 py-2">#{{ $history->trade_id }}</td>
                            <td class="px-4 py-2">{{ $history->trade->trader->name ?? '-' }}</td>
                            <td class="px-4 py-2">${{ number_format($history->amount_invested, 2) }}</td>
                            <td class="px-4 py-2">{{ $history->roi }}%</td>
                            <td class="px-4 py-2">${{ number_format($history->amount_returned, 2) }}</td>
                            <td class="px-4 py-2">{{ $history->trade->entry_timestamp ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $history->trade->exit_timestamp ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No trade history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $tradeHistories->links() }}
        </div>
    </div>
</x-layouts.admin>
