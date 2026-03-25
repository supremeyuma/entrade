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
        $inputClasses = $isDark
            ? 'border-slate-700 bg-slate-800 text-slate-100 focus:border-emerald-400 focus:ring-emerald-500/20'
            : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-400 focus:ring-emerald-200';
    @endphp

    <div class="space-y-3 sm:space-y-6">
        <section data-aos="fade-up" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative">
                    <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Trade Bot Run History</h1>
                    <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Search historical runs with tighter filters and a denser mobile summary table.</p>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="110" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <form method="GET" class="grid gap-3 md:grid-cols-2 xl:grid-cols-6">
                <input name="search" value="{{ request('search') }}" type="text" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" placeholder="Search config name or market">

                <select name="status" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                    <option value="">All Statuses</option>
                    <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                    <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                    <option value="failed" @selected(request('status') == 'failed')>Failed</option>
                </select>

                <input name="from" value="{{ request('from') }}" type="date" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                <input name="to" value="{{ request('to') }}" type="date" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">

                <select name="sort" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                    <option value="newest" @selected(request('sort') == 'newest')>Newest First</option>
                    <option value="oldest" @selected(request('sort') == 'oldest')>Oldest First</option>
                    <option value="roi" @selected(request('sort') == 'roi')>Highest ROI Target</option>
                </select>

                <button class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]" type="submit">
                    Filter
                </button>
            </form>
        </section>

        <section data-aos="fade-up" data-aos-delay="170" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="min-w-full text-sm text-left">
                <thead class="{{ $subtleSurfaceClasses }}">
                    <tr class="uppercase text-[11px] tracking-[0.16em]">
                        <th class="px-3 py-2.5 sm:px-4">ID</th>
                        <th class="px-3 py-2.5 sm:px-4">Market</th>
                        <th class="px-3 py-2.5 sm:px-4">ROI Target</th>
                        <th class="px-3 py-2.5 sm:px-4">Status</th>
                        <th class="px-3 py-2.5 sm:px-4">Trades</th>
                        <th class="px-3 py-2.5 sm:px-4">Avg ROI</th>
                        <th class="px-3 py-2.5 sm:px-4">Started</th>
                        <th class="px-3 py-2.5 sm:px-4">Completed</th>
                        <th class="px-3 py-2.5 sm:px-4">Repeat</th>
                        <th class="px-3 py-2.5 sm:px-4">Summary</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @forelse ($runs as $run)
                        @php
                            $config = $run->config ?? null;
                            $stats = $run->stats ?? [];
                        @endphp
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-3 sm:px-4 font-semibold">{{ $run->id }}</td>
                            <td class="px-3 py-3 sm:px-4">{{ $config->market ?? '-' }}</td>
                            <td class="px-3 py-3 sm:px-4">{{ $config->target_roi ?? '-' }}{{ $config?->target_roi !== null ? '%' : '' }}</td>
                            <td class="px-3 py-3 sm:px-4">
                                @php
                                    $statusClass = match ($run->status) {
                                        'completed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300',
                                        'running' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300',
                                        'pending' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/10 dark:text-sky-300',
                                        default => 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-300',
                                    };
                                @endphp
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ ucfirst($run->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-3 sm:px-4">{{ $run->trades_generated ?? '-' }}</td>
                            <td class="px-3 py-3 sm:px-4">{{ $run->average_roi ?? '-' }}{{ $run->average_roi !== null ? '%' : '' }}</td>
                            <td class="px-3 py-3 text-xs sm:px-4 sm:text-sm {{ $mutedTextClasses }}">{{ $run->started_at ?? '-' }}</td>
                            <td class="px-3 py-3 text-xs sm:px-4 sm:text-sm {{ $mutedTextClasses }}">{{ $run->completed_at ?? '-' }}</td>
                            <td class="px-3 py-3 sm:px-4">
                                @if ($config)
                                    <form method="POST" action="{{ route('admin.trade-bot.configs.rerun', $config) }}" onsubmit="return confirm('Are you sure you want to re-run this config?');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center rounded-2xl bg-sky-600 px-3 py-2 text-xs font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">
                                            Re-run
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs {{ $mutedTextClasses }}">N/A</span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-xs sm:px-4 {{ $mutedTextClasses }}">
                                <div>Total: {{ $stats['total_trades'] ?? '-' }}</div>
                                <div>Win Rate: {{ $stats['win_rate'] ?? '-' }}{{ isset($stats['win_rate']) ? '%' : '' }}</div>
                                <div>Avg ROI: {{ $stats['avg_roi'] ?? '-' }}{{ isset($stats['avg_roi']) ? '%' : '' }}</div>
                                <div>Max Loss: {{ $stats['max_loss'] ?? '-' }}{{ isset($stats['max_loss']) ? '%' : '' }}</div>
                                <div>From: {{ isset($stats['from']) ? optional($stats['from'])->format('Y-m-d') : '-' }}</div>
                                <div>To: {{ isset($stats['to']) ? optional($stats['to'])->format('Y-m-d') : '-' }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-8 text-center text-sm {{ $mutedTextClasses }}">No trade bot runs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <div class="mt-6">
            {{ $runs->links() }}
        </div>
    </div>
</x-layouts.admin>
