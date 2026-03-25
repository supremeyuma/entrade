<x-layouts.admin>
    @php
        $isDark = session('theme', 'light') === 'dark';
        $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-white' : 'border-slate-200 bg-white text-slate-900';
        $heroOverlayClasses = $isDark
            ? 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.18),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.18),_transparent_26%),linear-gradient(135deg,_#020617,_#0f172a_58%,_#111827)]'
            : 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
        $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
        $subtleSurfaceClasses = $isDark ? 'bg-slate-800 text-slate-300' : 'bg-slate-50 text-slate-600';
        $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
        $mutedTextClasses = $isDark ? 'text-slate-400' : 'text-slate-500';
    @endphp

    <div class="space-y-3 sm:space-y-6 max-w-6xl mx-auto">
        @if (session('success'))
            <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">{{ session('success') }}</div>
        @endif

        <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                        <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Trader: {{ $trader->name }}</h1>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.traders.edit', $trader) }}" class="rounded-2xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">Edit</a>
                        <form method="POST" action="{{ route('admin.traders.destroy', $trader) }}" onsubmit="return confirm('Are you sure?');">@csrf @method('DELETE')<button class="rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">Delete</button></form>
                        <form method="POST" action="{{ route('admin.traders.toggle-active', $trader) }}">@csrf<button class="rounded-2xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-amber-400 hover:shadow-lg active:scale-[0.99]">{{ $trader->is_active ? 'Deactivate' : 'Activate' }}</button></form>
                        <form method="POST" action="{{ route('admin.traders.toggle-featured', $trader) }}">@csrf<button class="rounded-2xl bg-fuchsia-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-fuchsia-500 hover:shadow-lg active:scale-[0.99]">{{ $trader->is_featured ? 'Unfeature' : 'Feature' }}</button></form>
                    </div>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="grid grid-cols-1 gap-3 md:grid-cols-4">
            <div class="rounded-[18px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}"><h2 class="text-sm {{ $mutedTextClasses }}">Total Trades</h2><div class="text-xl font-bold {{ $headingClasses }}">{{ $trader->trades->count() }}</div></div>
            <div class="rounded-[18px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}"><h2 class="text-sm {{ $mutedTextClasses }}">Avg ROI (%)</h2><div class="text-xl font-bold {{ $headingClasses }}">{{ $average_roi ?? '-' }}</div></div>
            <div class="rounded-[18px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}"><h2 class="text-sm {{ $mutedTextClasses }}">Win Rate</h2><div class="text-xl font-bold {{ $headingClasses }}">{{ $winRate }}%</div></div>
            <div class="rounded-[18px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}"><h2 class="text-sm {{ $mutedTextClasses }}">Subscribers</h2><div class="text-xl font-bold {{ $headingClasses }}">{{ $subscriberCount }}</div><a href="{{ route('admin.traders.subscribers', $trader) }}" class="mt-2 inline-block text-sm text-sky-600 hover:underline">View Subscribers</a></div>
        </section>

        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold {{ $headingClasses }}">Performance Trend (ROI)</h2>
            <div class="space-x-1">
                @foreach (['1w' => '1W', '3m' => '3M', '6m' => '6M', '12m' => '12M', '24m' => '24M'] as $key => $label)
                    <a href="{{ route('admin.traders.show', ['trader' => $trader->id, 'range' => $key]) }}" class="rounded border px-2 py-1 text-xs {{ request('range', '12m') == $key ? 'bg-sky-600 text-white border-sky-600' : 'bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200' }}">{{ $label }}</a>
                @endforeach
            </div>
        </div>

        <section data-aos="fade-up" data-aos-delay="180" class="rounded-[20px] sm:rounded-[28px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}"><h2 class="mb-2 text-lg font-semibold {{ $headingClasses }}">Performance Trend (ROI by Month)</h2><canvas id="roiChart" height="90"></canvas></section>

        <section data-aos="fade-up" data-aos-delay="220" class="rounded-[20px] sm:rounded-[28px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <h2 class="mb-4 text-lg font-semibold {{ $headingClasses }}">Trade History</h2>
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm">
                    <thead class="{{ $subtleSurfaceClasses }} sticky top-0"><tr><th class="px-3 py-2 sm:px-4">Type</th><th class="px-3 py-2 sm:px-4">Pair</th><th class="px-3 py-2 sm:px-4">Entry</th><th class="px-3 py-2 sm:px-4">Exit</th><th class="px-3 py-2 sm:px-4">Profit/Loss</th><th class="px-3 py-2 sm:px-4">Opened</th><th class="px-3 py-2 sm:px-4">Closed</th></tr></thead>
                    <tbody class="{{ $headingClasses }}">
                        @forelse ($trades as $trade)
                            <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                                <td class="px-3 py-2 sm:px-4 capitalize">{{ $trade->type }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ $trade->pair ?? $trade->symbol }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ $trade->entry_price }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ $trade->exit_price }}</td>
                                <td class="px-3 py-2 sm:px-4 {{ $trade->roi >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">{{ $trade->roi }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ $trade->entry_timestamp }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ $trade->exit_timestamp }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-6 text-center text-sm {{ $mutedTextClasses }}">No trades recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $trades->links() }}</div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('roiChart').getContext('2d');
        const roiChart = new Chart(ctx, {
            type: 'line',
            data: { labels: {!! json_encode($labels) !!}, datasets: [{ label: 'ROI (%)', data: {!! json_encode($roiData) !!}, backgroundColor: '#3b82f6' }] },
            options: { responsive: true, scales: { y: { beginAtZero: true, title: { display: true, text: 'ROI (%)' } }, x: { ticks: { maxRotation: 45, autoSkip: true } } } }
        });
    </script>
</x-layouts.admin>
