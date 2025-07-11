<x-layouts.admin>
    <div class="px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Trader: {{ $trader->name }}</h1>
            <a href="{{ route('admin.traders.trades.create', $trader) }}" class="btn btn-primary">
                + Add Trade
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow space-y-4">
            <div class="flex items-center gap-4">
                @if($trader->profile_photo)
                    <img src="{{ asset('storage/' . $trader->profile_photo) }}" alt="Photo"
                         class="w-24 h-24 rounded-full object-cover border">
                @endif
                <div>
                    <p class="text-lg font-semibold">{{ $trader->name }}</p>
                    <p class="text-sm text-gray-500">{{ $trader->bio }}</p>
                </div>
            </div>

            <div>
                <h2 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-2">Performance Metrics</h2>
                <pre class="bg-gray-100 dark:bg-gray-900 p-4 rounded text-sm overflow-x-auto">
{{ json_encode($trader->performance_metrics, JSON_PRETTY_PRINT) }}
                </pre>
            </div>
        </div>

        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Trade History</h2>

            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
                <table class="table-auto w-full text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Pair</th>
                            <th class="px-4 py-2">Entry</th>
                            <th class="px-4 py-2">Exit</th>
                            <th class="px-4 py-2">Profit/Loss</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Opened</th>
                            <th class="px-4 py-2">Closed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trader->trades as $trade)
                            <tr class="border-t dark:border-gray-700">
                                <td class="px-4 py-2 capitalize">{{ $trade->trade_type }}</td>
                                <td class="px-4 py-2">{{ $trade->pair ?? $trade->asset }}</td>
                                <td class="px-4 py-2">{{ $trade->entry_price }}</td>
                                <td class="px-4 py-2">{{ $trade->exit_price }}</td>
                                <td class="px-4 py-2 {{ $trade->profit_loss >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $trade->profit_loss }}
                                </td>
                                <td class="px-4 py-2 capitalize">{{ $trade->status }}</td>
                                <td class="px-4 py-2">{{ optional($trade->opened_at)->format('d M, H:i') }}</td>
                                <td class="px-4 py-2">{{ optional($trade->closed_at)->format('d M, H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-gray-500">No trades recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
