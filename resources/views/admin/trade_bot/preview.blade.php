<x-layouts.admin>
    @php
        $isDark = session('theme', 'light') === 'dark';
        $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-white' : 'border-slate-200 bg-white text-slate-900';
        $heroOverlayClasses = $isDark
            ? 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.18),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.18),_transparent_26%),linear-gradient(135deg,_#020617,_#0f172a_58%,_#111827)]'
            : 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
        $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
        $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
        $mutedTextClasses = $isDark ? 'text-slate-400' : 'text-slate-500';
    @endphp

    <div class="space-y-3 sm:space-y-6">
        <section data-aos="fade-up" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative">
                    <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Equity Curve Preview</h1>
                    <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Live simulation feedback with a denser mobile chart container and terminal-style job log.</p>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold sm:text-xl {{ $headingClasses }}">Backtest Equity Curve</h2>
                    <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Chart output updates after the preview request returns.</p>
                </div>
                <span id="loading" class="rounded-full px-3 py-1 text-xs font-semibold {{ $isDark ? 'bg-slate-800 text-slate-300' : 'bg-slate-100 text-slate-600' }}">Loading...</span>
            </div>

            <div class="mt-4 overflow-hidden rounded-[22px] border p-3 sm:p-4 {{ $isDark ? 'border-slate-700 bg-slate-950/80' : 'border-slate-200 bg-slate-50/80' }}">
                <canvas id="equityChart" height="100"></canvas>
            </div>

            <div id="error" class="mt-4 hidden rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-300">
                Failed to load data.
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="180" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold sm:text-xl {{ $headingClasses }}">Live Job Log</h3>
                    <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Polling refresh runs every 3 seconds while the job is active.</p>
                </div>
            </div>

            <pre id="logBox" class="mt-4 max-h-80 overflow-y-auto rounded-[22px] border border-emerald-500/20 bg-[#020617] p-3 text-xs font-mono text-emerald-300 shadow-inner sm:p-4 sm:text-sm">Loading logs...</pre>
        </section>
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
                                borderColor: '#0ea5e9',
                                backgroundColor: '#0ea5e9',
                                tension: 0.3
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: true },
                                title: {
                                    display: false
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

            function fetchJobLog() {
                fetch(`/admin/trade-bots/${configId}/log`)
                    .then(res => res.text())
                    .then(text => {
                        const box = document.getElementById('logBox');
                        box.textContent = text || 'No logs available yet...';
                        box.scrollTop = box.scrollHeight;
                    });
            }

            fetchJobLog();
            setInterval(fetchJobLog, 3000);
        </script>
    @endpush
</x-layouts.admin>
