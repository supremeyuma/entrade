@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $subtleSurfaceClasses = $isDark ? 'bg-slate-800/80 text-slate-400' : 'bg-slate-50 text-slate-500';
    $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
@endphp

<x-layouts.app>
<div class="mx-auto max-w-5xl px-4 py-6 sm:py-8">
    <div class="space-y-4 sm:space-y-6">
        <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
            <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
            <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Trading</p>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Trade Outcome Details</h1>
                <p class="mt-2 text-sm {{ $bodyTextClasses }}">Review trader performance, your subscription impact, and recent outcomes.</p>
            </div>
        </section>

        <div data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
            <h2 class="mb-4 text-base font-semibold text-emerald-600 dark:text-emerald-400 sm:text-lg">Trader Information</h2>
            <div class="grid grid-cols-1 gap-4 text-sm {{ $bodyTextClasses }} md:grid-cols-2">
                <div><span class="font-medium {{ $headingClasses }}">Name:</span> {{ $trader->name }}</div>
                <div><span class="font-medium {{ $headingClasses }}">Trader ID:</span> {{ $trader->trader_id }}</div>
                <div><span class="font-medium {{ $headingClasses }}">Cumulative ROI:</span> {{ number_format($cumulativeRoi, 2) }}%</div>
            </div>
        </div>

        <div data-aos="fade-up" data-aos-delay="160" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
            <h2 class="mb-4 text-base font-semibold text-emerald-600 dark:text-emerald-400 sm:text-lg">Outcome Information</h2>
            <div class="grid grid-cols-1 gap-4 text-sm {{ $bodyTextClasses }} md:grid-cols-2">
                <div><span class="font-medium {{ $headingClasses }}">Percentage Change:</span> {{ $percentageChange }}%</div>
                <div><span class="font-medium {{ $headingClasses }}">Recorded At:</span> {{ $lastHistory->created_at->format('M d, Y h:i A') }}</div>
            </div>
        </div>

        @if($userSubscription)
        <div data-aos="fade-up" data-aos-delay="200" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
            <h2 class="mb-4 text-base font-semibold text-emerald-600 dark:text-emerald-400 sm:text-lg">Your Subscription Details</h2>
            <div class="grid grid-cols-1 gap-4 text-sm {{ $bodyTextClasses }} md:grid-cols-2">
                <div><span class="font-medium {{ $headingClasses }}">Allocated Amount:</span> ${{ number_format($userSubscription->allocated_amount, 2) }}</div>
                <div><span class="font-medium {{ $headingClasses }}">Subscribed Since:</span> {{ $userSubscription->created_at->diffForHumans() }} ({{ $daysSubscribed }} days)</div>
                <div><span class="font-medium {{ $headingClasses }}">Gain/Loss:</span>
                    <span class="{{ $gainLoss >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                        {{ $gainLoss >= 0 ? '+' : '' }}${{ number_format($gainLoss, 2) }}
                    </span>
                </div>
                <div><span class="font-medium {{ $headingClasses }}">Updated Allocation:</span> ${{ number_format($newBalance, 2) }}</div>
            </div>
        </div>
        @else
        <div data-aos="fade-up" data-aos-delay="200" class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300">
            You are not currently subscribed to this trader.
        </div>
        @endif

        <div data-aos="fade-up" data-aos-delay="240" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
            <h2 class="mb-4 text-base font-semibold text-emerald-600 dark:text-emerald-400 sm:text-lg">Last 3 Trade Outcomes</h2>

            @if($recentOutcomes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full overflow-hidden rounded-md text-left text-sm">
                    <thead class="{{ $subtleSurfaceClasses }}">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">ROI</th>
                            <th class="px-4 py-3">Profit/Loss</th>
                        </tr>
                    </thead>
                    <tbody class="{{ $bodyTextClasses }}">
                        @foreach($recentOutcomes as $outcome)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-4 py-2">{{ $outcome->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-2">{{ $outcome->roi }}%</td>
                            <td class="px-4 py-2">
                                ${{ number_format($outcome->amount_returned - $outcome->amount_invested, 2) ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p class="{{ $bodyTextClasses }}">No recent trade outcomes found.</p>
            @endif
        </div>

        <div class="mt-2" data-aos="fade-up" data-aos-delay="280">
            <a href="{{ route('user.tradingDashboard') }}" class="inline-flex items-center rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">
                Back to Trade Dashboard
            </a>
        </div>
    </div>
</div>
</x-layouts.app>
