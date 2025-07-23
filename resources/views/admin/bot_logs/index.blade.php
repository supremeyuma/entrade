<x-layouts.admin>
    <div class="max-w-7xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-4">Bot Logs</h1>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Trader</th>
                        <th class="px-4 py-2">Market</th>
                        <th class="px-4 py-2">ROI</th>
                        <th class="px-4 py-2">Trades</th>
                        <th class="px-4 py-2">Summary</th>
                        <th class="px-4 py-2">Run At</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($logs as $log)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $log->id }}</td>
                            <td class="px-4 py-2">{{ $log->trader->name ?? '—' }}</td>
                            <td class="px-4 py-2">{{ ucfirst($log->market) }}</td>
                            <td class="px-4 py-2">{{ $log->roi }}%</td>
                            <td class="px-4 py-2">
                                {{ optional(json_decode($log->output_data))->trade_count ?? '0' }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ $log->summary }}</td>
                            <td class="px-4 py-2 text-sm">{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
