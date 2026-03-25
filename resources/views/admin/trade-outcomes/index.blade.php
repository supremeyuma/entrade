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
                <div class="relative flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                        <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Trade Outcomes</h1>
                        <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Review trader performance events and filter them without oversized mobile controls.</p>
                    </div>
                    <a href="{{ route('admin.trade-outcomes.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">
                        Add Outcome
                    </a>
                </div>
            </div>
        </section>

        @if (session('success'))
            <div data-aos="fade-up" data-aos-delay="70" class="rounded-[20px] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <section data-aos="fade-up" data-aos-delay="110" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <form method="GET" class="grid gap-3 md:grid-cols-[minmax(0,1fr)_auto_auto] md:items-end">
                <div>
                    <label for="trader_id" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Filter by Trader</label>
                    <select name="trader_id" id="trader_id" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                        <option value="">All Traders</option>
                        @foreach ($traders as $trader)
                            <option value="{{ $trader->id }}" {{ request('trader_id') == $trader->id ? 'selected' : '' }}>
                                {{ $trader->name }} ({{ $trader->trader_id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="inline-flex min-h-[40px] items-center justify-center rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">
                    Filter
                </button>

                <a href="{{ route('admin.trade-outcomes.index') }}" class="inline-flex min-h-[40px] items-center justify-center rounded-2xl border px-4 py-2.5 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $isDark ? 'border-slate-700 bg-slate-800 text-slate-100 hover:bg-slate-700' : 'border-slate-300 bg-white text-slate-900 hover:bg-slate-50' }}">
                    Reset
                </a>
            </form>
        </section>

        <section data-aos="fade-up" data-aos-delay="170" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="min-w-full text-sm">
                <thead class="{{ $subtleSurfaceClasses }}">
                    <tr class="text-left uppercase text-[11px] tracking-[0.16em]">
                        <th class="px-3 py-2.5 sm:px-4">Trader</th>
                        <th class="px-3 py-2.5 sm:px-4">Change</th>
                        <th class="px-3 py-2.5 sm:px-4">Description</th>
                        <th class="px-3 py-2.5 sm:px-4">Created</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @forelse ($tradeOutcomes as $outcome)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-3 sm:px-4">
                                <p class="font-semibold">{{ $outcome->trader->name }}</p>
                                <p class="text-xs {{ $mutedTextClasses }}">ID: {{ $outcome->trader->trader_id }}</p>
                            </td>
                            <td class="px-3 py-3 sm:px-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $outcome->percentage_change >= 0 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-300' }}">
                                    {{ $outcome->percentage_change > 0 ? '+' : '' }}{{ $outcome->percentage_change }}%
                                </span>
                            </td>
                            <td class="px-3 py-3 text-xs sm:px-4 sm:text-sm {{ $mutedTextClasses }}">
                                {{ $outcome->description ?: 'No description' }}
                            </td>
                            <td class="px-3 py-3 text-xs sm:px-4 sm:text-sm {{ $mutedTextClasses }}">
                                {{ $outcome->created_at->format('Y-m-d H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-sm {{ $mutedTextClasses }}">No trade outcomes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <div class="mt-4">
            {{ $tradeOutcomes->withQueryString()->links() }}
        </div>
    </div>
</x-layouts.admin>
