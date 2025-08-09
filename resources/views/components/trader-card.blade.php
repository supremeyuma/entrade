@props(['trader'])

<div 
    x-data="traderCard()"
    x-init='initChart({{ json_encode($trader->roiData) }})'
    class="bg-white dark:bg-gray-900 rounded-xl shadow p-4 w-full max-w-sm transition-transform hover:scale-[1.02] hover:shadow-lg"
>


    {{-- Skeleton Loader --}}
    <template x-if="loading">
        <div class="animate-pulse space-y-3">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                <div class="flex-1">
                    <div class="h-4 bg-gray-300 dark:bg-gray-700 w-3/4 rounded"></div>
                    <div class="h-3 bg-gray-200 dark:bg-gray-600 w-1/2 mt-2 rounded"></div>
                </div>
            </div>
            <div class="h-24 bg-gray-200 dark:bg-gray-800 rounded"></div>
        </div>
    </template>

    {{-- Trader Card --}}
    <div x-show="!loading" x-cloak>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ $trader->avatar_url ?? asset('images/default-avatar.png') }}" alt="{{ $trader->name }}" class="w-12 h-12 rounded-full object-cover">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $trader->name }}</h3>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <img src="{{ asset('images/flags/' . strtolower($trader->country_code) . '.svg') }}" class="w-4 h-4 mr-1">
                        <span>{{ $trader->country }}</span>
                    </div>
                </div>
            </div>
            {{-- Risk stars --}}
            <div class="text-yellow-500">
                @for ($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 inline {{ $i < $trader->risk_score ? 'fill-current' : 'text-gray-300 dark:text-gray-700' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24h-7.19L12 2 9.19 9.24H2l5.46 4.73L5.82 21z"/>
                    </svg>
                @endfor
            </div>
        </div>

        {{-- ROI Chart --}}
        <div class="bg-white dark:bg-gray-800 rounded shadow p-4 mt-4 w-full">
            <canvas x-ref="chart" id="roiChart" class="w-full h-16"></canvas>
            <div class="flex justify-end mt-2 space-x-2 text-xs text-gray-600 dark:text-gray-400">
                <button @click="updateTimeframe('1W')" :class="{'font-bold': selectedTimeframe === '1W'}">1W</button>
                <button @click="updateTimeframe('1M')" :class="{'font-bold': selectedTimeframe === '1M'}">1M</button>
                <button @click="updateTimeframe('12M')" :class="{'font-bold': selectedTimeframe === '12M'}">12M</button>
            </div>
        </div>

        {{-- Metrics --}}
        <div class="mt-4 space-y-1 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-300">ROI:</span>
                <span class="font-medium text-green-600 dark:text-green-400">{{ $trader->roi }}%</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-300">Subscribers:</span>
                <span class="font-medium text-gray-800 dark:text-gray-200">{{ number_format($trader->subscriber_count) }}</span>
            </div>
        </div>
        
        <div class="mt-4 flex justify-between items-center">
            <a href="{{ route('guests.trader-profile', $trader) }}" class="text-indigo-600 dark:text-indigo-400 text-sm font-semibold hover:underline">View Profile</a>
            <button class="bg-indigo-600 text-white text-xs px-3 py-1 rounded hover:bg-indigo-700">Copy</button>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--<script>
        const ctx = document.getElementById('roiChart').getContext('2d');
        const roiChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($trader->labels) !!},
                datasets: [{
                    label: 'ROI (%)',
                    data: {!! json_encode($trader->roiData) !!},
                    backgroundColor: '#3b82f6',
                    fill: true, // This makes it an area chart
                    backgroundColor: 'rgba(59, 130, 246, 0.3)', // Lighter fill color
                    borderColor: '#3b82f6',
                    tension: 0.3, // Optional: smooth curve
                    //pointRadius: 0 // Optional: remove points
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: false,
                            text: 'ROI (%)'
                        }
                    },
                    x: {
                        ticks: {
                            display: false,
                            minRotation: 0,
                            maxRotation: 45,
                            autoSkip: true
                        }
                    }
                }
            }
        });
    </script>