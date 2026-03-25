@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $subtleSurfaceClasses = $isDark ? 'bg-slate-800/80' : 'bg-slate-50';
    $textClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
    $mutedTextClasses = $isDark ? 'text-slate-400' : 'text-slate-500';
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
                    <div class="pointer-events-none absolute -right-8 top-5 h-20 w-20 rounded-full bg-cyan-400/10 blur-2xl animate-pulse"></div>
                    <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $mutedTextClasses }}">Funding</p>
                    <h2 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Deposit History</h2>
                    <p class="mt-2 text-sm {{ $textClasses }}">Review deposit activity, filter by period, and open invoices when needed.</p>
                </div>
            </section>

            @if ($deposits->isEmpty())
                <div data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-5 text-sm shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }} {{ $textClasses }}">You have no deposit history yet.</div>
            @else
                <section data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
                    <form method="GET" class="flex flex-wrap items-end gap-3">
                        <div>
                            <label class="mb-1 block text-sm {{ $textClasses }}">From</label>
                            <input type="date" name="from" value="{{ request('from') }}"
                                class="rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}" />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm {{ $textClasses }}">To</label>
                            <input type="date" name="to" value="{{ request('to') }}"
                                class="rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}" />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm {{ $textClasses }}">Status</label>
                            <select name="status" class="rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                                <option value="">All</option>
                                <option value="waiting" @selected(request('status')==='waiting')>Waiting</option>
                                <option value="finished" @selected(request('status')==='finished')>Finished</option>
                                <option value="rejected" @selected(request('status')==='rejected')>Rejected</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:ml-auto sm:w-auto sm:px-5 sm:py-3">
                            Filter
                        </button>
                    </form>
                </section>

                <div data-aos="fade-up" data-aos-delay="180" class="overflow-x-auto rounded-[24px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] {{ $surfaceClasses }}">
                    <table class="min-w-full text-sm text-left">
                        <thead class="uppercase {{ $subtleSurfaceClasses }} {{ $mutedTextClasses }}">
                            <tr>
                                @php
                                    $sort = request('sort');
                                    $dateSort = $sort === 'date_asc' ? 'date_desc' : 'date_asc';
                                    $amountSort = $sort === 'amount_asc' ? 'amount_desc' : 'amount_asc';
                                @endphp
                                <th class="px-3 py-2 sm:px-4">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => $dateSort]) }}" class="inline-flex items-center gap-1">
                                        Date
                                        @if($sort === 'date_asc')
                                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12l5-5 5 5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        @elseif($sort === 'date_desc')
                                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 8l5 5 5-5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-3 py-2 sm:px-4">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => $amountSort]) }}" class="inline-flex items-center gap-1">
                                        Amount
                                        @if($sort === 'amount_asc')
                                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12l5-5 5 5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        @elseif($sort === 'amount_desc')
                                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 8l5 5 5-5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-3 py-2 sm:px-4">Currency</th>
                                <th class="px-3 py-2 sm:px-4">Status</th>
                                <th class="px-3 py-2 sm:px-4">Invoice Link</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800 {{ $textClasses }}">
                            @foreach ($deposits as $deposit)
                                <tr class="transition duration-300 ease-out hover:bg-slate-50 dark:hover:bg-slate-800/70" role="link" tabindex="0" data-href="{{ route('user.deposit.show', $deposit->id) }}">
                                    <td class="px-3 py-2 sm:px-4">{{ $deposit->created_at->format('M d, Y H:i') }}</td>
                                    <td class="px-3 py-2 sm:px-4">{{ number_format($deposit->amount, 2) }}</td>
                                    <td class="px-3 py-2 sm:px-4">{{ strtoupper($deposit->currency) }}</td>
                                    <td class="px-3 py-2 sm:px-4">
                                        <span class="{{ $deposit->status === 'finished' ? 'text-emerald-600 dark:text-emerald-400' : ($deposit->status === 'rejected' ? 'text-rose-600 dark:text-rose-400' : 'text-amber-600 dark:text-amber-400') }}">
                                            {{ ucfirst($deposit->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 sm:px-4">
                                        @if (!empty($deposit->invoice_url))
                                            <a href="{{ $deposit->invoice_url }}" target="_blank" class="font-medium text-emerald-600 transition hover:text-emerald-500">View Invoice</a>
                                        @else
                                            <span class="{{ $mutedTextClasses }}">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="p-3 sm:p-4">
                        {{ $deposits->links('pagination::tailwind') }}
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            document.querySelectorAll('tr[data-href]').forEach(function (tr) {
                                tr.addEventListener('click', function () { window.location = tr.dataset.href; });
                                tr.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { window.location = tr.dataset.href; } });
                            });
                            document.querySelectorAll('table a').forEach(function (a) { a.addEventListener('click', function (e) { e.stopPropagation(); }); });
                        });
                    </script>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
