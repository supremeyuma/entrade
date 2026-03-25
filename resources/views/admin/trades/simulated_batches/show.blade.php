<x-layouts.admin>
    <div class="max-w-7xl mx-auto px-4 py-6 sm:py-8">
        <div class="mb-6">
            <h1 class="text-xl font-bold sm:text-2xl">Trades in Batch: {{ $batchId }}</h1>
            <a href="{{ route('admin.trade-bot.runs.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back to All Batches</a>
        </div>

        <div class="overflow-x-auto rounded-lg bg-white shadow-md">
            <table class="min-w-full text-left text-sm">
                <thead class="border-b bg-gray-100">
                    <tr>
                        <th class="px-3 py-3 sm:px-4">#</th>
                        <th class="px-3 py-3 sm:px-4">Symbol</th>
                        <th class="px-3 py-3 sm:px-4">Type</th>
                        <th class="px-3 py-3 sm:px-4">Entry</th>
                        <th class="px-3 py-3 sm:px-4">Exit</th>
                        <th class="px-3 py-3 sm:px-4">ROI %</th>
                        <th class="px-3 py-3 sm:px-4">Win</th>
                        <th class="px-3 py-3 sm:px-4">Timestamps</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($trades as $trade)
                        <tr>
                            <td class="px-3 py-2 sm:px-4">{{ $loop->iteration }}</td>
                            <td class="px-3 py-2 sm:px-4">{{ $trade->symbol }}</td>
                            <td class="px-3 py-2 sm:px-4 capitalize">{{ $trade->type }}</td>
                            <td class="px-3 py-2 sm:px-4">${{ number_format($trade->entry_price, 2) }}</td>
                            <td class="px-3 py-2 sm:px-4">${{ number_format($trade->exit_price, 2) }}</td>
                            <td class="px-3 py-2 text-sm sm:px-4 {{ $trade->roi >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($trade->roi, 2) }}%
                            </td>
                            <td class="px-3 py-2 sm:px-4">{{ $trade->roi >= 0 ? 'Yes' : 'No' }}</td>
                            <td class="px-3 py-2 text-xs sm:px-4">
                                {{ $trade->entry_timestamp }}<br>
                                {{ $trade->exit_timestamp }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500">No trades found for this batch.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
