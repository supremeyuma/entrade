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
    <div class="mx-auto max-w-6xl px-4 py-6 sm:py-8">
        <div class="space-y-4 sm:space-y-6">
            <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                    <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Trading</p>
                    <h1 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Trade History</h1>
                    <p class="mt-2 text-sm {{ $bodyTextClasses }}">Filter outcomes by date and trader, then export the current view if needed.</p>
                </div>
            </section>

            <section data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
                <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-end sm:gap-4">
                    <div>
                        <label for="start_date" class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="block w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                    </div>

                    <div>
                        <label for="end_date" class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="block w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                    </div>

                    <div>
                        <label for="trader_id" class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Trader</label>
                        <select name="trader_id" id="trader_id"
                                class="block w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                            <option value="">All</option>
                            @foreach($traders as $trader)
                                <option value="{{ $trader->id }}" @selected(request('trader_id') == $trader->id)>
                                    {{ $trader->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end">
                        <button type="submit"
                                class="rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">
                            Filter
                        </button>
                        <a href="{{ route('user.trade-history.export', request()->query()) }}"
                        class="rounded-2xl bg-slate-900 px-4 py-2 text-center text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-slate-700 hover:shadow-lg dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-white">
                            Export CSV
                        </a>
                    </div>
                </form>
            </section>

            @if($histories->count())
            <div data-aos="fade-up" data-aos-delay="180" class="w-full overflow-x-auto rounded-[24px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] {{ $surfaceClasses }}">
                <table class="min-w-full whitespace-nowrap text-left text-xs sm:text-sm">
                    <thead class="{{ $subtleSurfaceClasses }}">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Date</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Trader</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Pair</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Side</th>
                            <th class="px-3 py-2 text-right sm:px-4 sm:py-3">Profit/Loss</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Entry / Exit</th>
                        </tr>
                    </thead>
                    <tbody class="{{ $bodyTextClasses }}">
                        @foreach($histories as $history)
                            <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                                <td class="px-3 py-2 sm:px-4 sm:py-3">
                                    {{ $history->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $history->trader->name }}</td>
                                <td class="px-3 py-2 text-right sm:px-4 sm:py-3">
                                    {{ $history->trade->symbol }}
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $history->trade->type ?? $history->trade->trade_type ?? 'N/A' }}</td>
                                <td class="px-3 py-2 text-right font-semibold sm:px-4 sm:py-3 {{ $history->profit_loss_amount >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                    ${{ number_format($history->profit_loss_amount, 2) }}
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">
                                    {{ $history->trade->entry_timestamp ? \Carbon\Carbon::parse($history->trade->entry_timestamp)->format('Y-m-d H:i') : '-' }}
                                    /
                                    {{ $history->trade->exit_timestamp ? \Carbon\Carbon::parse($history->trade->exit_timestamp)->format('Y-m-d H:i') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p data-aos="fade-up" data-aos-delay="180" class="rounded-[24px] border p-5 text-sm shadow-sm {{ $surfaceClasses }} {{ $bodyTextClasses }}">You have no trade history yet.</p>
            @endif
        </div>
    </div>
</x-layouts.app>
