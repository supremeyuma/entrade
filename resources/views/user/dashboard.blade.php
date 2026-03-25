<x-layouts.app>
    @php
        $isDark = session('theme', 'light') === 'dark';

        $formatSignedCurrency = function ($value) {
            $prefix = $value > 0 ? '+' : '';
            return $prefix . '$' . number_format($value, 2);
        };

        $heroClasses = $isDark
            ? 'border-slate-800 bg-slate-950 text-white'
            : 'border-slate-200 bg-white text-slate-900';

        $heroOverlayClasses = $isDark
            ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.18),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.18),_transparent_26%),linear-gradient(135deg,_#020617,_#0f172a_58%,_#111827)]'
            : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';

        $surfaceClasses = $isDark
            ? 'border-slate-800 bg-slate-900'
            : 'border-slate-200 bg-white';

        $subtleSurfaceClasses = $isDark
            ? 'bg-slate-800'
            : 'bg-slate-50';

        $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
        $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-500';
        $mutedTextClasses = $isDark ? 'text-slate-400' : 'text-slate-500';
        $secondaryTextClasses = $isDark ? 'text-slate-200' : 'text-slate-700';
        $dividerClasses = $isDark ? 'border-slate-800' : 'border-slate-200';
        $outlineButtonClasses = $isDark
            ? 'border-slate-700 bg-slate-900 text-slate-100 hover:bg-slate-800'
            : 'border-slate-300 bg-white/80 text-slate-900 hover:bg-slate-50';
        $primaryButtonClasses = $isDark
            ? 'bg-cyan-400 text-slate-950 hover:bg-cyan-300'
            : 'bg-slate-900 text-white hover:bg-slate-800';
    @endphp

    <div class="space-y-4 sm:space-y-6">
        <section class="overflow-hidden rounded-[24px] sm:rounded-[28px] border shadow-xl {{ $heroClasses }}">
            <div class="relative px-4 py-5 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>

                <div class="relative flex flex-col gap-4 sm:gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-[0.24em] {{ $mutedTextClasses }}">Dashboard</p>
                        <h1 class="mt-2 text-2xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">{{ strtok($user->name, ' ') ?: $user->name }}</h1>
                        <p class="mt-1 text-xs sm:mt-2 sm:text-sm {{ $mutedTextClasses }}">Portfolio Value</p>
                        <p class="mt-1 text-3xl font-semibold sm:text-4xl {{ $headingClasses }}">${{ number_format($portfolioValue, 2) }}</p>
                    </div>

                    <div class="grid gap-2 sm:gap-3 sm:grid-cols-2 lg:min-w-[360px]">
                        <a href="{{ route('user.deposit.create') }}" class="rounded-xl sm:rounded-2xl border px-3 py-2.5 sm:px-4 sm:py-3 text-center text-xs sm:text-sm font-semibold transition {{ $outlineButtonClasses }}">
                            Deposit Funds
                        </a>
                        <a href="{{ route('user.withdrawals.create') }}" class="rounded-xl sm:rounded-2xl border px-3 py-2.5 sm:px-4 sm:py-3 text-center text-xs sm:text-sm font-semibold transition {{ $outlineButtonClasses }}">
                            Withdraw
                        </a>
                        <a href="{{ route('user.tradingDashboard') }}" class="rounded-xl sm:rounded-2xl border px-3 py-2.5 sm:px-4 sm:py-3 text-center text-xs sm:text-sm font-semibold transition {{ $outlineButtonClasses }}">
                            Trade Dashboard
                        </a>
                        <a href="{{ route('user.trade.search') }}" class="rounded-xl sm:rounded-2xl border px-3 py-2.5 sm:px-4 sm:py-3 text-center text-xs sm:text-sm font-semibold transition {{ $outlineButtonClasses }}">
                            Find Traders
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-3 sm:gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[20px] sm:rounded-[24px] border p-4 sm:p-5 shadow-sm {{ $surfaceClasses }}">
                <p class="text-xs sm:text-sm {{ $bodyTextClasses }}">Main Balance</p>
                <p class="mt-1.5 sm:mt-2 text-2xl sm:text-3xl font-semibold {{ $headingClasses }}">${{ number_format($main_balance, 2) }}</p>
            </div>

            <div class="rounded-[20px] sm:rounded-[24px] border p-4 sm:p-5 shadow-sm {{ $surfaceClasses }}">
                <p class="text-xs sm:text-sm {{ $bodyTextClasses }}">Trade Balance</p>
                <p class="mt-1.5 sm:mt-2 text-2xl sm:text-3xl font-semibold {{ $headingClasses }}">${{ number_format($trade_balance, 2) }}</p>
            </div>

            <div class="rounded-[20px] sm:rounded-[24px] border p-4 sm:p-5 shadow-sm {{ $surfaceClasses }}">
                <p class="text-xs sm:text-sm {{ $bodyTextClasses }}">Net Profit</p>
                <p class="mt-1.5 sm:mt-2 text-2xl sm:text-3xl font-semibold {{ $netProfit >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                    {{ $formatSignedCurrency($netProfit) }}
                </p>
            </div>

            <div class="rounded-[20px] sm:rounded-[24px] border p-4 sm:p-5 shadow-sm {{ $surfaceClasses }}">
                <p class="text-xs sm:text-sm {{ $bodyTextClasses }}">Active Traders</p>
                <p class="mt-1.5 sm:mt-2 text-2xl sm:text-3xl font-semibold {{ $headingClasses }}">{{ $activeSubscriptions->count() }}</p>
            </div>
        </section>

        <section class="grid gap-4 sm:gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <div class="rounded-[24px] sm:rounded-[28px] border p-4 sm:p-6 shadow-sm {{ $surfaceClasses }}">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg sm:text-xl font-semibold {{ $headingClasses }}">Overview</h2>
                    <a href="{{ route('user.tradingDashboard') }}" class="text-xs sm:text-sm font-medium {{ $mutedTextClasses }} hover:text-slate-900 dark:hover:text-slate-100">
                        Open trade dashboard
                    </a>
                </div>

                <div class="mt-4 sm:mt-5 grid gap-3 sm:gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl sm:rounded-3xl p-4 sm:p-5 {{ $subtleSurfaceClasses }}">
                        <p class="text-xs sm:text-sm {{ $bodyTextClasses }}">Allocated Capital</p>
                        <p class="mt-1.5 sm:mt-2 text-xl sm:text-2xl font-semibold {{ $headingClasses }}">${{ number_format($copiedCapital, 2) }}</p>
                    </div>

                    <div class="rounded-2xl sm:rounded-3xl p-4 sm:p-5 {{ $subtleSurfaceClasses }}">
                        <p class="text-xs sm:text-sm {{ $bodyTextClasses }}">Average ROI</p>
                        <p class="mt-1.5 sm:mt-2 text-xl sm:text-2xl font-semibold {{ $averageRoi >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                            {{ number_format($averageRoi, 2) }}%
                        </p>
                    </div>

                    <div class="rounded-2xl sm:rounded-3xl p-4 sm:p-5 {{ $subtleSurfaceClasses }}">
                        <p class="text-xs sm:text-sm {{ $bodyTextClasses }}">Win Rate</p>
                        <p class="mt-1.5 sm:mt-2 text-xl sm:text-2xl font-semibold {{ $headingClasses }}">{{ number_format($winRate, 1) }}%</p>
                    </div>

                    <div class="rounded-2xl sm:rounded-3xl p-4 sm:p-5 {{ $subtleSurfaceClasses }}">
                        <p class="text-xs sm:text-sm {{ $bodyTextClasses }}">30D P/L</p>
                        <p class="mt-1.5 sm:mt-2 text-xl sm:text-2xl font-semibold {{ $thirtyDayProfit >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                            {{ $formatSignedCurrency($thirtyDayProfit) }}
                        </p>
                    </div>
                </div>

                @if ($activeSubscriptions->isNotEmpty())
                    <div class="mt-5 sm:mt-6 border-t pt-4 sm:pt-5 {{ $dividerClasses }}">
                        <h3 class="text-xs sm:text-sm font-medium uppercase tracking-[0.16em] {{ $mutedTextClasses }}">Active Allocations</h3>
                        <div class="mt-3 space-y-2.5 sm:space-y-3">
                            @foreach ($activeSubscriptions->take(3) as $subscription)
                                <div class="flex items-center justify-between rounded-xl sm:rounded-2xl px-3 py-2.5 sm:px-4 sm:py-3 {{ $subtleSurfaceClasses }}">
                                    <p class="text-sm sm:text-base font-medium {{ $headingClasses }}">{{ $subscription->trader->name ?? 'Trader' }}</p>
                                    <p class="text-xs sm:text-sm font-semibold {{ $secondaryTextClasses }}">${{ number_format($subscription->allocated_amount ?? 0, 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="rounded-[24px] sm:rounded-[28px] border p-4 sm:p-6 shadow-sm {{ $surfaceClasses }}">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg sm:text-xl font-semibold {{ $headingClasses }}">Recent Transactions</h2>
                    <a href="{{ route('user.transactions.index') }}" class="text-xs sm:text-sm font-medium {{ $mutedTextClasses }} hover:text-slate-900 dark:hover:text-slate-100">
                        View all
                    </a>
                </div>

                <div class="mt-4 sm:mt-5 space-y-2.5 sm:space-y-3">
                    @forelse ($recentTransactions as $tx)
                        <div class="flex items-start justify-between gap-3 sm:gap-4 rounded-xl sm:rounded-2xl px-3 py-2.5 sm:px-4 sm:py-3 {{ $subtleSurfaceClasses }}">
                            <div>
                                <p class="text-sm sm:text-base font-medium {{ $headingClasses }}">{{ ucfirst($tx->type ?? 'Transaction') }}</p>
                                <p class="mt-1 text-xs {{ $bodyTextClasses }}">{{ $tx->user_note ?? $tx->category ?? '-' }}</p>
                            </div>
                            <p class="text-xs sm:text-sm font-semibold {{ $tx->amount >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                {{ $formatSignedCurrency($tx->amount) }}
                            </p>
                        </div>
                    @empty
                        <div class="rounded-xl sm:rounded-2xl px-3 py-4 sm:px-4 sm:py-5 text-sm {{ $subtleSurfaceClasses }} {{ $bodyTextClasses }}">
                            No recent transactions.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</x-layouts.app>
