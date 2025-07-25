<x-layouts.admin>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Trade Bot Run History</h1>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <form method="GET" class="flex flex-wrap gap-4 mb-4 items-end">
                <input name="search" value="{{ request('search') }}" type="text"
                    class="input input-bordered w-64" placeholder="Search config name or market">

                <select name="status" class="select select-bordered">
                    <option value="">All Statuses</option>
                    <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                    <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                    <option value="failed" @selected(request('status') == 'failed')>Failed</option>
                </select>

                <input name="from" value="{{ request('from') }}" type="date" class="input input-bordered">
                <input name="to" value="{{ request('to') }}" type="date" class="input input-bordered">

                <select name="sort" class="select select-bordered">
                    <option value="newest" @selected(request('sort') == 'newest')>Newest First</option>
                    <option value="oldest" @selected(request('sort') == 'oldest')>Oldest First</option>
                    <option value="roi" @selected(request('sort') == 'roi')>Highest ROI Target</option>
                </select>

                <button class="btn btn-indigo" type="submit">Filter</button>
            </form>

            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Market</th>
                        <th class="px-4 py-3">ROI Target</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Trades</th>
                        <th class="px-4 py-3">Avg ROI</th>
                        <th class="px-4 py-3">Started</th>
                        <th class="px-4 py-3">Completed</th>
                        <th class="px-4 py-3">Completed</th>
                        <th class="px-4 py-3">Repeat</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-100">
                    @forelse ($runs as $run)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2">{{ $run->id }}</td>
                            <td class="px-4 py-2">{{ $run->config->market ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $run->config->target_roi ?? '-' }}%</td>
                            <td class="px-4 py-2">
                                @if ($run->status === 'completed')
                                    <span class="text-green-600 font-semibold">Completed</span>
                                @elseif ($run->status === 'running')
                                    <span class="text-yellow-500 font-semibold">Running</span>
                                @else
                                    <span class="text-red-500 font-semibold">Failed</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $run->trades_generated ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $run->average_roi ?? '-' }}%</td>
                            <td class="px-4 py-2">{{ $run->started_at ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $run->completed_at ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('admin.trade-bot.configs.rerun', $config) }}" onsubmit="return confirm('Are you sure you want to re-run this config?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm bg-blue-600 hover:bg-blue-700 text-white">Re-run</button>
                                </form>
                            </td>
                            <td class="text-sm text-gray-700">
                                <div>Total: {{ $run->stats['total_trades'] }}</div>
                                <div>Win Rate: {{ $run->stats['win_rate'] }}%</div>
                                <div>Avg ROI: {{ $run->stats['avg_roi'] }}%</div>
                                <div>Max Loss: {{ $run->stats['max_loss'] }}%</div>
                                <div>From: {{ optional($run->stats['from'])->format('Y-m-d') }}</div>
                                <div>To: {{ optional($run->stats['to'])->format('Y-m-d') }}</div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500">No trade bot runs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $runs->links() }}
        </div>
    </div>
</x-layouts.admin>
