@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
    $inputClasses = $isDark
        ? 'border-slate-700 bg-slate-800 text-slate-100 focus:border-emerald-400 focus:ring-emerald-500/20'
        : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-400 focus:ring-emerald-200';
@endphp

<x-layouts.app>
    <div class="mx-auto max-w-3xl px-4 py-6 sm:py-8">
        <div class="space-y-4 sm:space-y-6">
            <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                    <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Funding</p>
                    <h2 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Confirm Withdrawal</h2>
                    <p class="mt-2 text-sm {{ $bodyTextClasses }}">Review the withdrawal details and submit the final confirmation.</p>
                </div>
            </section>

            @if ($errors->any())
                <div data-aos="fade-up" data-aos-delay="120" class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div data-aos="fade-up" data-aos-delay="160" class="space-y-3 rounded-[24px] border p-4 text-sm shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:space-y-4 sm:p-6 {{ $surfaceClasses }}">
                <div><strong class="{{ $headingClasses }}">Cryptocurrency:</strong> <span class="{{ $bodyTextClasses }}">{{ $withdrawal->cryptocurrency }}</span></div>
                <div><strong class="{{ $headingClasses }}">Requested Amount:</strong> <span class="{{ $bodyTextClasses }}">${{ number_format($withdrawal->usd_amount ?? $withdrawal->amount, 2) }} USD</span></div>
                <div><strong class="{{ $headingClasses }}">Crypto Amount:</strong> <span class="{{ $bodyTextClasses }}">{{ number_format($withdrawal->amount, 8, '.', ',') }} {{ $withdrawal->cryptocurrency }}</span></div>
                <div><strong class="{{ $headingClasses }}">Rate:</strong> <span class="{{ $bodyTextClasses }}">1 {{ $withdrawal->cryptocurrency }} = ${{ number_format($withdrawal->exchange_rate ?? 0, 2, '.', ',') }}</span></div>
                <div><strong class="{{ $headingClasses }}">Network:</strong> <span class="{{ $bodyTextClasses }}">{{ $withdrawal->network ?? 'N/A' }}</span></div>
                <div><strong class="{{ $headingClasses }}">To:</strong> <span class="{{ $bodyTextClasses }}">{{ $withdrawal->wallet_address }}</span></div>
                <div><strong class="{{ $headingClasses }}">Fee:</strong> <span class="{{ $bodyTextClasses }}">{{ number_format($withdrawal->fee, 8, '.', ',') }} {{ $withdrawal->cryptocurrency }}</span></div>
                <div><strong class="{{ $headingClasses }}">Net Amount:</strong> <span class="{{ $bodyTextClasses }}">{{ number_format($withdrawal->amount - $withdrawal->fee, 8, '.', ',') }} {{ $withdrawal->cryptocurrency }}</span></div>
            </div>

            <form action="{{ route('user.withdrawals.confirm.process') }}" method="POST" data-aos="fade-up" data-aos-delay="200" class="space-y-4 rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
                @csrf
                <input type="hidden" name="token" value="{{ $withdrawal->confirmation_token }}">

                @if ($withdrawal->user->two_factor_secret)
                    <div>
                        <label class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">2FA Code</label>
                        <input type="text" name="code"
                            class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}" required>
                    </div>
                @else
                    <div class="text-sm text-amber-600 dark:text-amber-400">
                        You do not have 2FA enabled. Click confirm to proceed.
                    </div>
                @endif

                <div class="flex justify-end">
                    <button class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">Confirm Withdrawal</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
