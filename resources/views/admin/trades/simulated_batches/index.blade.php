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
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Simulated Trade Batches</h1>
                    <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Inspect generated trade batches with compact filters and a denser results table.</p>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="110" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <form method="GET" class="grid gap-3 md:grid-cols-[minmax(0,1fr)_auto_auto_auto] md:items-end">
                <input name="search" value="{{ request('search') }}" type="text" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" placeholder="Search by trader">
                <input name="from" value="{{ request('from') }}" type="date" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                <input name="to" value="{{ request('to') }}" type="date" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                <button class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]" type="submit">
                    Filter
                </button>
            </form>
        </section>

        <section data-aos="fade-up" data-aos-delay="170" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="min-w-full text-sm text-left">
                <thead class="{{ $subtleSurfaceClasses }}">
                    <tr class="uppercase text-[11px] tracking-[0.16em]">
                        <th class="px-3 py-2.5 sm:px-4">Batch ID</th>
                        <th class="px-3 py-2.5 sm:px-4">Trader</th>
                        <th class="px-3 py-2.5 sm:px-4">Trades</th>
                        <th class="px-3 py-2.5 sm:px-4">Avg ROI</th>
                        <th class="px-3 py-2.5 sm:px-4">Win Rate</th>
                        <th class="px-3 py-2.5 sm:px-4">From</th>
                        <th class="px-3 py-2.5 sm:px-4">To</th>
                        <th class="px-3 py-2.5 sm:px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @forelse ($batches as $batch)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-3 font-mono text-xs text-sky-600 dark:text-sky-300 sm:px-4">{{ $batch->batch_id }}</td>
                            <td class="px-3 py-3 sm:px-4">{{ optional($batch->trader)->name ?? 'Unknown' }}</td>
                            <td class="px-3 py-3 sm:px-4">{{ $batch->trade_count }}</td>
                            <td class="px-3 py-3 sm:px-4">{{ number_format($batch->average_roi, 2) }}%</td>
                            <td class="px-3 py-3 sm:px-4">{{ number_format($batch->win_rate, 2) }}%</td>
                            <td class="px-3 py-3 text-xs sm:px-4 sm:text-sm {{ $mutedTextClasses }}">{{ \Carbon\Carbon::parse($batch->from_date)->format('Y-m-d') }}</td>
                            <td class="px-3 py-3 text-xs sm:px-4 sm:text-sm {{ $mutedTextClasses }}">{{ \Carbon\Carbon::parse($batch->to_date)->format('Y-m-d') }}</td>
                            <td class="px-3 py-3 sm:px-4">
                                <a href="{{ route('admin.trade-bot.show', $batch->batch_id) }}" class="inline-flex items-center rounded-2xl bg-sky-600 px-3 py-2 text-xs font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-sm {{ $mutedTextClasses }}">No simulated trade batches found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <div class="mt-6">
            {{ $batches->links() }}
        </div>
    </div>
</x-layouts.admin>
