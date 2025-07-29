<x-layouts.admin>
    <div class="px-4 py-6 max-w-6xl mx-auto">

        <h1 class="text-2xl font-bold mb-4">Trader: {{ $trader->name }}</h1>

        {{-- Performance Analytics --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 shadow p-4 rounded">
                <h2 class="text-sm text-gray-500 dark:text-gray-400">Total Trades</h2>
                <div class="text-xl font-bold">{{ $trader->trades->count() }}</div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow p-4 rounded">
                <h2 class="text-sm text-gray-500 dark:text-gray-400">Avg ROI (%)</h2>
                <div class="text-xl font-bold">
                    {{ $trader->performance_metrics['roi'] ?? '—' }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow p-4 rounded">
                <h2 class="text-sm text-gray-500 dark:text-gray-400">Win Rate</h2>
                <div class="text-xl font-bold">
                    {{ $trader->performance_metrics['win_rate'] ?? '—' }}%
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow p-4 rounded">
                <h2 class="text-sm text-gray-500 dark:text-gray-400">Max Drawdown</h2>
                <div class="text-xl font-bold">
                    {{ $trader->performance_metrics['max_drawdown'] ?? '—' }}%
                </div>
            </div>
        </div>

        {{-- Chart (Optional ROI Bar Chart) --}}
        <div class="bg-white dark:bg-gray-800 rounded shadow p-4 mb-8">
            <h2 class="text-lg font-semibold mb-2">Performance Trend</h2>
            <canvas id="roiChart" height="90"></canvas>
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
                            
                            <th class="px-4 py-2">Opened</th>
                            <th class="px-4 py-2">Closed</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trader->trades as $trade)
                            <tr class="border-t dark:border-gray-700">
                                <td class="px-4 py-2 capitalize">{{ $trade->type }}</td>
                                <td class="px-4 py-2">{{ $trade->pair ?? $trade->symbol }}</td>
                                <td class="px-4 py-2">{{ $trade->entry_price }}</td>
                                <td class="px-4 py-2">{{ $trade->exit_price }}</td>
                                <td class="px-4 py-2 {{ $trade->roi >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $trade->roi }}
                                </td>
                                
                                <td class="px-4 py-2">{{ $trade->entry_timestamp }}</td>
                                <td class="px-4 py-2">{{ $trade->exit_timestamp}}</td>
                                

    
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('roiChart').getContext('2d');
    const roiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'ROI %',
                data: [{{ $trader->performance_metrics['roi'] ?? '0' }},
                       {{ $trader->performance_metrics['roi'] ?? '0' }},
                       {{ $trader->performance_metrics['roi'] ?? '0' }},
                       {{ $trader->performance_metrics['roi'] ?? '0' }},
                       {{ $trader->performance_metrics['roi'] ?? '0' }},
                       {{ $trader->performance_metrics['roi'] ?? '0' }}],
                backgroundColor: '#3b82f6'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</x-layouts.admin>

