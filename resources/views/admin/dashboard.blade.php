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
        <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="pointer-events-none absolute -right-10 top-6 hidden h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl animate-pulse sm:block"></div>
                <div class="relative flex flex-col gap-3 sm:gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                        <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Admin Dashboard</h1>
                        <p class="mt-1 text-[11px] sm:mt-2 sm:text-sm {{ $mutedTextClasses }}">High-level platform activity, user growth, and review queues.</p>
                    </div>

                    <div class="grid gap-2 sm:gap-3 sm:grid-cols-2 lg:min-w-[320px]">
                        <a href="{{ route('admin.users.index') }}" class="rounded-lg sm:rounded-2xl border px-2.5 py-2 sm:px-4 sm:py-3 text-center text-[11px] sm:text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $surfaceClasses }}">
                            Manage Users
                        </a>
                        <a href="{{ route('admin.traders.index') }}" class="rounded-lg sm:rounded-2xl border px-2.5 py-2 sm:px-4 sm:py-3 text-center text-[11px] sm:text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $surfaceClasses }}">
                            Manage Traders
                        </a>
                        <a href="{{ route('admin.withdrawals.index') }}" class="rounded-lg sm:rounded-2xl border px-2.5 py-2 sm:px-4 sm:py-3 text-center text-[11px] sm:text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $surfaceClasses }}">
                            Review Withdrawals
                        </a>
                        <a href="{{ route('admin.trades.create') }}" class="rounded-lg sm:rounded-2xl border px-2.5 py-2 sm:px-4 sm:py-3 text-center text-[11px] sm:text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $surfaceClasses }}">
                            Add Trade
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="100" class="grid gap-2.5 sm:gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[18px] sm:rounded-[24px] border p-3 sm:p-5 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
                <p class="text-[11px] sm:text-sm {{ $mutedTextClasses }}">Total Users</p>
                <p class="mt-1 text-xl sm:mt-2 sm:text-3xl font-semibold text-sky-500">{{ $totalUsers }}</p>
            </div>
            <div class="rounded-[18px] sm:rounded-[24px] border p-3 sm:p-5 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
                <p class="text-[11px] sm:text-sm {{ $mutedTextClasses }}">Verified Traders</p>
                <p class="mt-1 text-xl sm:mt-2 sm:text-3xl font-semibold text-emerald-500">{{ $traders }}</p>
            </div>
            <div class="rounded-[18px] sm:rounded-[24px] border p-3 sm:p-5 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
                <p class="text-[11px] sm:text-sm {{ $mutedTextClasses }}">Pending Withdrawals</p>
                <p class="mt-1 text-xl sm:mt-2 sm:text-3xl font-semibold text-rose-500">{{ $pendingWithdrawals }}</p>
            </div>
            <div class="rounded-[18px] sm:rounded-[24px] border p-3 sm:p-5 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
                <p class="text-[11px] sm:text-sm {{ $mutedTextClasses }}">Pending Subscriptions</p>
                <p class="mt-1 text-xl sm:mt-2 sm:text-3xl font-semibold text-amber-500">
                    <a href="{{ route('admin.subscriptions.index') }}" class="hover:underline">{{ $pendingSubscriptions }}</a>
                </p>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="180" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <div class="flex items-center justify-between">
                <h2 class="text-base sm:text-xl font-semibold {{ $headingClasses }}">Recent Trades</h2>
                <span class="text-[11px] sm:text-sm {{ $mutedTextClasses }}">Latest activity</span>
            </div>

            <div class="mt-3 overflow-x-auto sm:mt-5">
                <table class="w-full text-left text-sm">
                    <thead class="{{ $subtleSurfaceClasses }}">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Trader</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Pair</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Type</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Result</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody class="{{ $headingClasses }}">
                        @forelse ($recentTrades as $trade)
                            <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                                <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $trade->trader->name }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $trade->pair }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">{{ ucfirst($trade->type) }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3 {{ $trade->profit >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                    {{ $trade->profit }} USD
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $trade->created_at->format('d M, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-4 text-center text-sm {{ $mutedTextClasses }}">No recent trades</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layouts.admin>
