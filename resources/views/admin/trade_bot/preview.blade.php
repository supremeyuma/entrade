<x-layouts.admin>
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Equity Curve Preview</h2>

        <canvas id="equityChart" height="100"></canvas>

        <h3 class="text-xl font-semibold mt-10 mb-2 text-gray-800 dark:text-white">Live Job Log</h3>
            <pre id="logBox" class="bg-black text-green-400 p-4 rounded-md max-h-80 overflow-y-auto text-sm font-mono shadow-inner">Loading logs...</pre>


        <div id="loading" class="text-center mt-6 text-gray-600">Loading...</div>
        <div id="error" class="text-center mt-6 text-red-500 hidden">Failed to load data.</div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const configId = {{ $config->id }};

        fetch(`/admin/trade-bots/${configId}/preview`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('loading').style.display = 'none';
                const ctx = document.getElementById('equityChart').getContext('2d');

                const labels = data.roi_curve.map(p => new Date(p.timestamp).toLocaleDateString());
                const equity = data.roi_curve.map(p => p.equity);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Equity Curve',
                            data: equity,
                            fill: false,
                            borderColor: '#4f46e5',
                            backgroundColor: '#4f46e5',
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: true },
                            title: {
                                display: true,
                                text: 'Backtest Equity Curve'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: true,
                                    text: 'Equity ($)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Time'
                                }
                            }
                        }
                    }
                });
            })
            .catch(() => {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('error').classList.remove('hidden');
            });


            //JOB Log UI
            function fetchJobLog() {
                fetch(`/admin/trade-bots/${configId}/log`)
                    .then(res => res.text())
                    .then(text => {
                        const box = document.getElementById('logBox');
                        box.textContent = text || 'No logs available yet...';
                        box.scrollTop = box.scrollHeight;
                    });
            }

            // Initial load + interval
            fetchJobLog();
            setInterval(fetchJobLog, 3000); // Refresh every 3 seconds

    </script>
    @endpush
</x-layouts.admin>
