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
    <div class="mx-auto max-w-5xl px-4 py-6 sm:py-8">
        <div class="space-y-4 sm:space-y-6">
            <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                    <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Funding</p>
                    <h2 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Withdrawal History</h2>
                    <p class="mt-2 text-sm {{ $bodyTextClasses }}">Filter your withdrawals by date or amount and track current statuses.</p>
                </div>
            </section>

            @if (session('success'))
                <div data-aos="fade-up" data-aos-delay="120" class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div data-aos="fade-up" data-aos-delay="140" class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($withdrawals->isEmpty())
                <div data-aos="fade-up" data-aos-delay="160" class="rounded-[24px] border p-5 text-sm shadow-sm {{ $surfaceClasses }} {{ $bodyTextClasses }}">You have no withdrawal history yet.</div>
            @else
                <section data-aos="fade-up" data-aos-delay="160" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
                    <form method="GET" class="flex flex-wrap items-end gap-3">
                        <div>
                            <label class="mb-1 block text-sm {{ $bodyTextClasses }}">From</label>
                            <input type="date" name="from" value="{{ request('from') }}"
                                class="rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}" />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm {{ $bodyTextClasses }}">To</label>
                            <input type="date" name="to" value="{{ request('to') }}"
                                class="rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}" />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm {{ $bodyTextClasses }}">Sort By</label>
                            <select name="sort" onchange="this.form.submit()"
                                    class="rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                                <option value="">Newest First</option>
                                <option value="date_asc" @selected(request('sort') === 'date_asc')>Oldest First</option>
                                <option value="amount_asc" @selected(request('sort') === 'amount_asc')>Amount Up</option>
                                <option value="amount_desc" @selected(request('sort') === 'amount_desc')>Amount Down</option>
                            </select>
                        </div>
                        <button type="submit"
                                class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:ml-auto sm:w-auto sm:px-5 sm:py-3">
                            Filter
                        </button>
                    </form>
                </section>

                <div data-aos="fade-up" data-aos-delay="200" class="overflow-x-auto rounded-[24px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] {{ $surfaceClasses }}">
                    <table class="min-w-full text-left text-sm">
                        <thead class="{{ $subtleSurfaceClasses }}">
                            <tr>
                                <th class="px-3 py-2 sm:px-4">Date</th>
                                <th class="px-3 py-2 sm:px-4">Crypto</th>
                                <th class="px-3 py-2 sm:px-4">Amount</th>
                                <th class="px-3 py-2 sm:px-4">To</th>
                                <th class="px-3 py-2 sm:px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800 {{ $bodyTextClasses }}">
                            @forelse ($withdrawals as $withdrawal)
                                <tr class="transition duration-300 ease-out hover:bg-slate-50 dark:hover:bg-slate-800/70">
                                    <td class="px-3 py-2 sm:px-4">{{ $withdrawal->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-3 py-2 sm:px-4">{{ $withdrawal->cryptocurrency }}</td>
                                    <td class="px-3 py-2 sm:px-4">
                                        <div>${{ number_format($withdrawal->usd_amount ?? $withdrawal->amount, 2) }} USD</div>
                                        <div class="text-xs {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">{{ number_format($withdrawal->amount, 8, '.', ',') }} {{ $withdrawal->cryptocurrency }}</div>
                                    </td>
                                    <td class="truncate px-3 py-2 sm:px-4">{{ $withdrawal->wallet_address }}</td>
                                    <td class="px-3 py-2 sm:px-4">
                                        <span class="rounded-full px-2 py-1 text-xs font-medium
                                            @class([
                                                'bg-slate-100 text-slate-800 dark:bg-slate-500/10 dark:text-slate-300' => $withdrawal->status === 'unconfirmed',
                                                'bg-amber-100 text-amber-800 dark:bg-amber-500/10 dark:text-amber-300' => $withdrawal->status === 'pending',
                                                'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-300' => $withdrawal->status === 'completed',
                                                'bg-rose-100 text-rose-800 dark:bg-rose-500/10 dark:text-rose-300' => $withdrawal->status === 'rejected',
                                                'bg-sky-100 text-sky-800 dark:bg-sky-500/10 dark:text-sky-300' => $withdrawal->status === 'approved',
                                                'bg-slate-200 text-slate-700 dark:bg-slate-700/60 dark:text-slate-200' => $withdrawal->status === 'cancelled',
                                            ])
                                        ">
                                            {{ ucfirst($withdrawal->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-sm {{ $bodyTextClasses }}">No withdrawals yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
