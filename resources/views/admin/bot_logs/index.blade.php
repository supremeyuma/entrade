<x-layouts.admin>
    <div class="max-w-7xl mx-auto px-4 py-6 sm:py-10">
        <h1 class="mb-4 text-xl font-bold sm:text-2xl">Bot Logs</h1>
        <div class="overflow-x-auto rounded-[20px] bg-white shadow-sm dark:bg-slate-900">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 dark:bg-slate-800 dark:text-slate-300"><tr><th class="px-3 py-2 sm:px-4">ID</th><th class="px-3 py-2 sm:px-4">Trader</th><th class="px-3 py-2 sm:px-4">Market</th><th class="px-3 py-2 sm:px-4">ROI</th><th class="px-3 py-2 sm:px-4">Trades</th><th class="px-3 py-2 sm:px-4">Summary</th><th class="px-3 py-2 sm:px-4">Run At</th></tr></thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <td class="px-3 py-2 sm:px-4">{{ $log->id }}</td>
                            <td class="px-3 py-2 sm:px-4">{{ $log->trader->name ?? '-' }}</td>
                            <td class="px-3 py-2 sm:px-4">{{ ucfirst($log->market) }}</td>
                            <td class="px-3 py-2 sm:px-4">{{ $log->roi }}%</td>
                            <td class="px-3 py-2 sm:px-4">{{ optional(json_decode($log->output_data))->trade_count ?? '0' }}</td>
                            <td class="px-3 py-2 text-sm text-slate-500 sm:px-4">{{ $log->summary }}</td>
                            <td class="px-3 py-2 text-sm sm:px-4">{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
