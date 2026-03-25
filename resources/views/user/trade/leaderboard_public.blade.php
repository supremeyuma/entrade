@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $subtleSurfaceClasses = $isDark ? 'bg-slate-800/80 text-slate-400' : 'bg-slate-50 text-slate-500';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
@endphp

<x-layouts.app>
<div class="mx-auto max-w-5xl px-4 py-6 sm:py-8">
    <div class="space-y-4 sm:space-y-6">
        <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
            <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
            <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Trading</p>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Top 5 Traders</h1>
                <p class="mt-2 text-sm {{ $bodyTextClasses }}">A compact public view of the highest-performing traders.</p>
            </div>
        </section>

        <div data-aos="fade-up" data-aos-delay="120" class="overflow-x-auto rounded-[24px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] {{ $surfaceClasses }}">
            <table class="min-w-full text-sm">
                <thead class="{{ $subtleSurfaceClasses }}">
                    <tr>
                        <th class="px-3 py-3 text-left sm:px-4">Name</th>
                        <th class="px-3 py-3 text-left sm:px-4">Trader ID</th>
                        <th class="px-3 py-3 text-left sm:px-4">ROI (%)</th>
                        <th class="px-3 py-3 text-left sm:px-4">Win Rate (%)</th>
                        <th class="px-3 py-3 text-left sm:px-4">Subscribers</th>
                    </tr>
                </thead>
                <tbody class="{{ $bodyTextClasses }}">
                    @foreach($traders as $trader)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-2 sm:px-4">{{ $trader->name }}</td>
                            <td class="px-3 py-2 sm:px-4">{{ $trader->trader_id }}</td>
                            <td class="px-3 py-2 sm:px-4">{{ $trader->roi }}</td>
                            <td class="px-3 py-2 sm:px-4">{{ $trader->win_rate }}</td>
                            <td class="px-3 py-2 sm:px-4">{{ $trader->subscribers }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-layouts.app>
