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
        ? 'border-slate-700 bg-slate-800 text-slate-100 focus:border-emerald-400 focus:ring-emerald-500/20'
        : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-400 focus:ring-emerald-200';
@endphp

<x-layouts.app>
<div class="mx-auto max-w-5xl px-4 py-6 sm:py-8" x-data="{ copied: false }">
    <div class="space-y-4 sm:space-y-6">
        <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
            <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
            <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Growth</p>
                <h2 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">My Referrals</h2>
                <p class="mt-2 text-sm {{ $bodyTextClasses }}">Track invites, copy your referral link, and monitor bonuses earned.</p>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
            <label class="mb-2 block text-sm font-semibold {{ $bodyTextClasses }}">Your Referral Link</label>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <input type="text"
                       readonly
                       value="{{ auth()->user()->referral_link }}"
                       class="w-full rounded-2xl border px-4 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                <button
                    @click="navigator.clipboard.writeText('{{ auth()->user()->referral_link }}'); copied = true; setTimeout(() => copied = false, 1800)"
                    class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
                    <span x-text="copied ? 'Copied' : 'Copy'"></span>
                </button>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="170" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="rounded-[24px] border p-4 text-sm shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
                <p class="{{ $bodyTextClasses }}">Total Referrals</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900 dark:text-slate-100">{{ auth()->user()->referralCount() }}</p>
            </div>
            <div class="rounded-[24px] border p-4 text-sm shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
                <p class="{{ $bodyTextClasses }}">Total Bonus Earned</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900 dark:text-slate-100">${{ number_format(auth()->user()->referralBonusTotal(), 2) }}</p>
            </div>
        </section>

        <div data-aos="fade-up" data-aos-delay="220" class="overflow-x-auto rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
            <h3 class="mb-3 text-lg font-semibold text-slate-900 dark:text-slate-100">Referral History</h3>

            @if($referrals->count())
                <table class="w-full text-sm">
                    <thead class="{{ $subtleSurfaceClasses }}">
                        <tr class="text-left">
                            <th class="px-3 py-2">#</th>
                            <th class="px-3 py-2">Name</th>
                            <th class="px-3 py-2">Email</th>
                            <th class="px-3 py-2">Referred On</th>
                            <th class="px-3 py-2">Bonus</th>
                        </tr>
                    </thead>
                    <tbody class="{{ $bodyTextClasses }}">
                        @foreach($referrals as $referral)
                            <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                                <td class="px-3 py-2">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2">{{ $referral->referred->name ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $referral->referred->email ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $referral->referred_at?->format('d M Y') ?? '-' }}</td>
                                <td class="px-3 py-2 font-semibold text-emerald-600 dark:text-emerald-400">
                                    ${{ number_format($referral->bonus_amount ?? 0, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm {{ $bodyTextClasses }}">You have not referred anyone yet.</p>
            @endif
        </div>
    </div>
</div>
</x-layouts.app>
