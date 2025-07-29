<x-layouts.admin>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Trades in Batch: {{ $batchId }}</h1>
            <a href="{{ route('admin.trade-bot.runs.index') }}" class="text-indigo-600 hover:underline text-sm">&larr; Back to All Batches</a>
        </div>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Symbol</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Entry</th>
                        <th class="px-4 py-3">Exit</th>
                        <th class="px-4 py-3">ROI %</th>
                        <th class="px-4 py-3">Win</th>
                        <th class="px-4 py-3">Timestamps</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($trades as $trade)
                        <tr>
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $trade->symbol }}</td>
                            <td class="px-4 py-2 capitalize">{{ $trade->type }}</td>
                            <td class="px-4 py-2">${{ number_format($trade->entry_price, 2) }}</td>
                            <td class="px-4 py-2">${{ number_format($trade->exit_price, 2) }}</td>
                            <td class="px-4 py-2 text-sm {{ $trade->roi >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($trade->roi, 2) }}%
                            </td>
                            <td class="px-4 py-2">{{ $trade->roi >= 0 ? '✅' : '❌' }}</td>
                            <td class="px-4 py-2 text-xs">
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
