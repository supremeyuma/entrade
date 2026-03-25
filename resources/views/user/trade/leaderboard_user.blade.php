@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $subtleSurfaceClasses = $isDark ? 'bg-slate-800/80 text-slate-400' : 'bg-slate-50 text-slate-500';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
    $inputClasses = $isDark
        ? 'border-slate-700 bg-slate-800 text-slate-100 placeholder:text-slate-500 focus:border-emerald-400 focus:ring-emerald-500/20'
        : 'border-slate-200 bg-slate-50 text-slate-900 placeholder:text-slate-400 focus:border-emerald-400 focus:ring-emerald-200';
@endphp

<x-layouts.app>
<div class="mx-auto max-w-7xl px-4 py-6 sm:py-8">
    <div class="space-y-4 sm:space-y-6">
        <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
            <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
            <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Trading</p>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Trader Leaderboard</h1>
                <p class="mt-2 text-sm {{ $bodyTextClasses }}">Filter, compare, and subscribe to traders from one interactive board.</p>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
            <form method="GET" class="grid grid-cols-1 items-end gap-3 md:grid-cols-6 md:gap-4">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or ID"
                        class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}" />
                </div>
                <div>
                    <input type="number" step="0.01" name="min_roi" value="{{ request('min_roi') }}" placeholder="Min ROI (%)"
                        class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}" />
                </div>
                <div>
                    <input type="number" step="0.01" name="min_win_rate" value="{{ request('min_win_rate') }}" placeholder="Min Win Rate (%)"
                        class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}" />
                </div>
                <div>
                    <select name="sort" class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                        <option value="roi" {{ request('sort') == 'roi' ? 'selected' : '' }}>Sort by ROI</option>
                        <option value="win_rate" {{ request('sort') == 'win_rate' ? 'selected' : '' }}>Sort by Win Rate</option>
                        <option value="subscribers" {{ request('sort') == 'subscribers' ? 'selected' : '' }}>Sort by Subscribers</option>
                        <option value="total_trades" {{ request('sort') == 'total_trades' ? 'selected' : '' }}>Sort by Total Trades</option>
                        <option value="avg_return_per_trade" {{ request('sort') == 'avg_return_per_trade' ? 'selected' : '' }}>Sort by Avg Return/Trade</option>
                    </select>
                </div>
                <div>
                    <select name="direction" class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">Filter & Sort</button>
                    <a href="{{ route('user.leaderboard') }}" class="block w-full rounded-2xl bg-slate-900 px-4 py-2 text-center text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-slate-700 hover:shadow-lg dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-white">Reset</a>
                </div>
            </form>
        </section>

        <div data-aos="fade-up" data-aos-delay="180" class="overflow-x-auto rounded-[24px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] {{ $surfaceClasses }}">
            <table class="w-full table-auto text-sm">
                <thead class="{{ $subtleSurfaceClasses }}">
                    <tr>
                        <th class="px-3 py-2 text-left">Trader Name</th>
                        <th class="px-3 py-2 text-left">Trader ID</th>
                        <th class="px-3 py-2 text-right">ROI (%)</th>
                        <th class="px-3 py-2 text-right">Win Rate (%)</th>
                        <th class="px-3 py-2 text-right">Subscribers</th>
                        <th class="px-3 py-2 text-right">Total Trades</th>
                        <th class="px-3 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="{{ $bodyTextClasses }}">
                    @forelse ($traders as $trader)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-2">
                                <a href="{{ route('guests.trader-profile', $trader->id) }}" class="font-medium text-emerald-600 hover:underline">
                                    {{ $trader->name }}
                                </a>
                            </td>
                            <td class="px-3 py-2">
                                <a href="{{ route('guests.trader-profile', $trader->id) }}" class="font-medium text-emerald-600 hover:underline">
                                    {{ $trader->trader_id }}
                                </a>
                            </td>
                            <td class="px-3 py-2 text-right">{{ number_format($trader->roi, 2) }}%</td>
                            <td class="px-3 py-2 text-right">{{ number_format($trader->win_rate, 2) }}%</td>
                            <td class="px-3 py-2 text-right">{{ $trader->subscriptions_count }}</td>
                            <td class="px-3 py-2 text-right">{{ $trader->trades_count }}</td>
                            <td class="space-x-2 px-3 py-2 text-center">
                                @if (!$user->subscriptions->contains('trader_id', $trader->id))
                                    <a href="{{ route('user.subscribe', $trader->id) }}" class="inline-flex rounded-2xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">
                                        Copy Trader
                                    </a>
                                @else
                                    <span class="rounded-2xl bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Subscribed</span>
                                @endif

                                <form method="POST" action="{{ route('user.traders.addToCompare', $trader->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="rounded-2xl bg-slate-900 px-3 py-2 text-xs font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-slate-700 hover:shadow-lg dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-white">Add to Compare</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-sm {{ $bodyTextClasses }}">No traders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $traders->links() }}
        </div>

        <div class="flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('user.leaderboard', array_merge(request()->query(), ['export' => 1])) }}" class="inline-flex rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">
                Export CSV
            </a>
            <a href="{{ route('user.traders.compare') }}" class="inline-flex rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-slate-700 hover:shadow-lg dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-white">
                Compare Selected Traders
            </a>
        </div>
    </div>
</div>
</x-layouts.app>
