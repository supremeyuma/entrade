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
        <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                        <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Traders</h1>
                    </div>
                    <a href="{{ route('admin.traders.create') }}" class="inline-flex rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">+ Add Trader</a>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="100" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <form method="GET" class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search trader..." class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 md:w-64 {{ $inputClasses }}">
                <select name="sort" class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 md:w-52 {{ $inputClasses }}">
                    <option value="">Sort by</option>
                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                    <option value="roi" {{ request('sort') === 'roi' ? 'selected' : '' }}>ROI (High to Low)</option>
                    <option value="trades" {{ request('sort') === 'trades' ? 'selected' : '' }}>Trade Count</option>
                </select>
                <button type="submit" class="rounded-2xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">Apply</button>
            </form>
        </section>

        <section data-aos="fade-up" data-aos-delay="160" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="table-auto w-full text-sm">
                <thead class="{{ $subtleSurfaceClasses }}">
                    <tr>
                        <th class="px-3 py-2 text-left sm:px-4">Name</th>
                        <th class="px-3 py-2 text-left sm:px-4">Trader ID</th>
                        <th class="px-3 py-2 text-left sm:px-4">ROI</th>
                        <th class="px-3 py-2 text-left sm:px-4">Trades</th>
                        <th class="px-3 py-2 text-left sm:px-4">Win Rate</th>
                        <th class="px-3 py-2 text-center sm:px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @forelse ($traders as $trader)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-3 font-medium sm:px-4">{{ $trader->name }}</td>
                            <td class="px-3 py-3 font-medium sm:px-4">{{ $trader->trader_id }}</td>
                            <td class="px-3 py-3 sm:px-4"><div class="w-full"><div class="mb-1 text-xs font-semibold">{{ $trader->average_roi }}%</div></div></td>
                            <td class="px-3 py-3 sm:px-4">{{ $trader->trades->count() }}</td>
                            <td class="px-3 py-3 {{ $mutedTextClasses }} sm:px-4">{{ $trader->winRate }}</td>
                            <td class="px-3 py-3 text-center sm:px-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.traders.show', $trader) }}" class="rounded-2xl bg-sky-600 px-3 py-2 text-xs font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">View</a>
                                    <a href="{{ route('admin.traders.edit', $trader) }}" class="rounded-2xl bg-amber-500 px-3 py-2 text-xs font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-amber-400 hover:shadow-lg active:scale-[0.99]">Edit</a>
                                    <form action="{{ route('admin.traders.destroy', $trader) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="rounded-2xl bg-rose-600 px-3 py-2 text-xs font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-6 text-center text-sm {{ $mutedTextClasses }}">No traders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <div class="mt-6">{{ $traders->links() }}</div>
    </div>
</x-layouts.admin>
