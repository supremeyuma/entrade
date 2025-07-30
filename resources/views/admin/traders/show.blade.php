<x-layouts.admin>
    <div class="px-4 py-6 max-w-6xl mx-auto">

        {{-- Flash message --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex flex-wrap items-center justify-between gap-2">
            <h1 class="text-2xl font-bold">Trader: {{ $trader->name }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.traders.edit', $trader) }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">Edit</a>

                <form method="POST" action="{{ route('admin.traders.destroy', $trader) }}" onsubmit="return confirm('Are you sure?');">
                    @csrf @method('DELETE')
                    <button class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700">Delete</button>
                </form>

                <form method="POST" action="{{ route('admin.traders.toggle-active', $trader) }}">
                    @csrf
                    <button class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600">
                        {{ $trader->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.traders.toggle-featured', $trader) }}">
                    @csrf
                    <button class="bg-purple-600 text-white px-4 py-2 rounded shadow hover:bg-purple-700">
                        {{ $trader->is_featured ? 'Unfeature' : 'Feature' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 shadow p-4 rounded">
                <h2 class="text-sm text-gray-500 dark:text-gray-400">Total Trades</h2>
                <div class="text-xl font-bold">{{ $trader->trades->count() }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow p-4 rounded">
                <h2 class="text-sm text-gray-500 dark:text-gray-400">Avg ROI (%)</h2>
                <div class="text-xl font-bold">{{ $average_roi ?? '—' }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow p-4 rounded">
                <h2 class="text-sm text-gray-500 dark:text-gray-400">Win Rate</h2>
                <div class="text-xl font-bold">{{ $winRate  }}%</div>
            </div>
            <!--<div class="bg-white dark:bg-gray-800 shadow p-4 rounded">
                <h2 class="text-sm text-gray-500 dark:text-gray-400">Max Drawdown</h2>
                <div class="text-xl font-bold">{{ $trader->performance_metrics['max_drawdown'] ?? '—' }}%</div>
            </div>-->
            <div class="bg-white dark:bg-gray-800 shadow p-4 rounded">
                <h2 class="text-sm text-gray-500 dark:text-gray-400">Subscribers</h2>
                <div class="text-xl font-bold">{{ $subscriberCount }}</div>
                <a href="{{ route('admin.traders.subscribers', $trader) }}" class="text-sm text-indigo-600 hover:underline mt-2 inline-block">View Subscribers</a>
            </div>
        </div>

        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold">Performance Trend (ROI)</h2>
            <div class="space-x-1">
                @foreach (['1w' => '1W', '3m' => '3M', '6m' => '6M', '12m' => '12M', '24m' => '24M'] as $key => $label)
                    <a href="{{ route('admin.traders.show', ['trader' => $trader->id, 'range' => $key]) }}"
                    class="text-xs px-2 py-1 rounded border {{ request('range', '12m') == $key ? 'bg-indigo-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
        



        {{-- ROI Chart --}}
        <div class="bg-white dark:bg-gray-800 rounded shadow p-4 mb-8">
            <h2 class="text-lg font-semibold mb-2">Performance Trend (ROI by Month)</h2>
            <canvas id="roiChart" height="90"></canvas>
        </div>

        {{-- Trade History --}}
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Trade History</h2>
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
                <table class="table-auto w-full text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 sticky top-0">
                        <tr>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Pair</th>
                            <th class="px-4 py-2">Entry</th>
                            <th class="px-4 py-2">Exit</th>
                            <th class="px-4 py-2">Profit/Loss</th>
                            <th class="px-4 py-2">Opened</th>
                            <th class="px-4 py-2">Closed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trades as $trade)
                            <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 capitalize">{{ $trade->type }}</td>
                                <td class="px-4 py-2">{{ $trade->pair ?? $trade->symbol }}</td>
                                <td class="px-4 py-2">{{ $trade->entry_price }}</td>
                                <td class="px-4 py-2">{{ $trade->exit_price }}</td>
                                <td class="px-4 py-2 {{ $trade->roi >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $trade->roi }}</td>
                                <td class="px-4 py-2">{{ $trade->entry_timestamp }}</td>
                                <td class="px-4 py-2">{{ $trade->exit_timestamp }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">No trades recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $trades->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('roiChart').getContext('2d');
        const roiChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'ROI (%)',
                    data: {!! json_encode($roiData) !!},
                    backgroundColor: '#3b82f6'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'ROI (%)'
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            autoSkip: true
                        }
                    }
                }
            }
        });
    </script>


</x-layouts.admin>
