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

    <div class="space-y-3 sm:space-y-6">
        <section data-aos="fade-up" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                        <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Trades in Batch</h1>
                        <p class="mt-1 text-xs font-medium sm:text-sm {{ $mutedTextClasses }}">{{ $batchId }}</p>
                    </div>
                    <a href="{{ route('admin.trade-bot.runs.index') }}" class="inline-flex items-center justify-center rounded-2xl border px-4 py-2 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $isDark ? 'border-slate-700 bg-slate-900/80 text-slate-100 hover:bg-slate-800' : 'border-slate-300 bg-white/80 text-slate-900 hover:bg-slate-50' }}">
                        Back to All Batches
                    </a>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="min-w-full text-left text-sm">
                <thead class="{{ $subtleSurfaceClasses }}">
                    <tr class="uppercase text-[11px] tracking-[0.16em]">
                        <th class="px-3 py-2.5 sm:px-4">#</th>
                        <th class="px-3 py-2.5 sm:px-4">Symbol</th>
                        <th class="px-3 py-2.5 sm:px-4">Type</th>
                        <th class="px-3 py-2.5 sm:px-4">Entry</th>
                        <th class="px-3 py-2.5 sm:px-4">Exit</th>
                        <th class="px-3 py-2.5 sm:px-4">ROI %</th>
                        <th class="px-3 py-2.5 sm:px-4">Win</th>
                        <th class="px-3 py-2.5 sm:px-4">Timestamps</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @forelse ($trades as $trade)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-3 sm:px-4">{{ $loop->iteration }}</td>
                            <td class="px-3 py-3 font-semibold sm:px-4">{{ $trade->symbol }}</td>
                            <td class="px-3 py-3 capitalize sm:px-4">{{ $trade->type }}</td>
                            <td class="px-3 py-3 sm:px-4">${{ number_format($trade->entry_price, 2) }}</td>
                            <td class="px-3 py-3 sm:px-4">${{ number_format($trade->exit_price, 2) }}</td>
                            <td class="px-3 py-3 text-sm sm:px-4 {{ $trade->roi >= 0 ? 'text-emerald-600 dark:text-emerald-300' : 'text-rose-600 dark:text-rose-300' }}">
                                {{ number_format($trade->roi, 2) }}%
                            </td>
                            <td class="px-3 py-3 sm:px-4">{{ $trade->roi >= 0 ? 'Yes' : 'No' }}</td>
                            <td class="px-3 py-3 text-xs sm:px-4 {{ $mutedTextClasses }}">
                                <div>{{ $trade->entry_timestamp }}</div>
                                <div>{{ $trade->exit_timestamp }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-sm {{ $mutedTextClasses }}">No trades found for this batch.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
</x-layouts.admin>
