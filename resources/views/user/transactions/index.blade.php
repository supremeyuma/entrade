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
                    <div class="pointer-events-none absolute -right-10 top-6 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl animate-pulse"></div>
                    <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Account</p>
                    <h1 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Transaction History</h1>
                    <p class="mt-2 text-sm {{ $bodyTextClasses }}">View credits, debits, and account activity in one compact timeline.</p>
                </div>
            </section>

            <div data-aos="fade-up" data-aos-delay="120" class="overflow-x-auto rounded-[24px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] {{ $surfaceClasses }}">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left {{ $subtleSurfaceClasses }} dark:border-slate-800">
                            <th class="px-3 py-2 sm:px-4"><a href="?sort_by=created_at&direction={{ $sortBy === 'created_at' && $direction === 'asc' ? 'desc' : 'asc' }}">Date</a></th>
                            <th class="px-3 py-2 sm:px-4"><a href="?sort_by=type&direction={{ $sortBy === 'type' && $direction === 'asc' ? 'desc' : 'asc' }}">Type</a></th>
                            <th class="px-3 py-2 sm:px-4"><a href="?sort_by=category&direction={{ $sortBy === 'category' && $direction === 'asc' ? 'desc' : 'asc' }}">Details</a></th>
                            <th class="px-3 py-2 sm:px-4"><a href="?sort_by=amount&direction={{ $sortBy === 'amount' && $direction === 'asc' ? 'desc' : 'asc' }}">Amount</a></th>
                        </tr>
                    </thead>
                    <tbody class="{{ $bodyTextClasses }}">
                        @forelse($transactions as $tx)
                            <tr class="border-b border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                                <td class="px-3 py-2 sm:px-4">{{ $tx->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ ucfirst($tx->type) }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ $tx->user_note ?? $tx->category ?? '-' }}</td>
                                <td class="px-3 py-2 font-semibold sm:px-4 {{ $tx->amount >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">${{ number_format($tx->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-3 py-5 text-center text-sm {{ $bodyTextClasses }}">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
