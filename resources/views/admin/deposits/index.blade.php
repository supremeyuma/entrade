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
        $inputClasses = $isDark
            ? 'border-slate-700 bg-slate-800 text-slate-100 focus:border-emerald-400 focus:ring-emerald-500/20'
            : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-400 focus:ring-emerald-200';
    @endphp

    <div class="space-y-3 sm:space-y-6">
        <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative">
                    <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Deposits</h1>
                    <p class="mt-1 text-[11px] sm:mt-2 sm:text-sm {{ $mutedTextClasses }}">Search invoices, filter statuses, and review incoming funding activity.</p>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="100" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <form method="GET" class="grid grid-cols-1 gap-2.5 sm:grid-cols-4">
                <input type="text" name="q" placeholder="Search user or invoice" value="{{ request('q') }}" class="rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}" />
                <select name="status" class="rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                    <option value="">All statuses</option>
                    <option value="waiting" {{ request('status')=='waiting' ? 'selected' : '' }}>Waiting</option>
                    <option value="finished" {{ request('status')=='finished' ? 'selected' : '' }}>Finished</option>
                    <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <input type="date" name="from" value="{{ request('from') }}" class="rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}" />
                <div class="flex gap-2">
                    <input type="date" name="to" value="{{ request('to') }}" class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}" />
                    <button class="rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">Filter</button>
                </div>
            </form>
        </section>

        <section data-aos="fade-up" data-aos-delay="160" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="w-full text-left text-sm">
                <thead class="{{ $subtleSurfaceClasses }} uppercase text-xs">
                    <tr>
                        <th class="px-3 py-3 sm:px-4">User</th>
                        @php
                            $sort = request('sort');
                            $dateSort = $sort === 'date_asc' ? 'date_desc' : 'date_asc';
                            $amountSort = $sort === 'amount_asc' ? 'amount_desc' : 'amount_asc';
                        @endphp
                        <th class="px-3 py-3 sm:px-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $dateSort]) }}" class="inline-flex items-center gap-1">
                                Date
                            </a>
                        </th>
                        <th class="px-3 py-3 sm:px-4">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $amountSort]) }}" class="inline-flex items-center gap-1">
                                Amount
                            </a>
                        </th>
                        <th class="px-3 py-3 sm:px-4">Invoice</th>
                        <th class="px-3 py-3 sm:px-4">Status</th>
                        <th class="px-3 py-3 text-right sm:px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @foreach($deposits as $d)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-3 sm:px-4">{{ $d->user->name ?? '-' }}<br/><span class="text-xs {{ $mutedTextClasses }}">{{ $d->user->email ?? '' }}</span></td>
                            <td class="px-3 py-3 sm:px-4">{{ $d->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-3 py-3 sm:px-4">${{ number_format($d->amount,2) }}</td>
                            <td class="px-3 py-3 sm:px-4">{{ $d->invoice_id }}</td>
                            <td class="px-3 py-3 sm:px-4">{{ ucfirst($d->status) }}</td>
                            <td class="px-3 py-3 text-right sm:px-4">
                                <a href="{{ route('admin.deposits.show', $d->id) }}" class="inline-flex items-center rounded-2xl bg-sky-600 px-3 py-2 text-xs sm:text-sm font-medium text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <div class="mt-4">
            {{ $deposits->links('pagination::tailwind') }}
        </div>
    </div>
</x-layouts.admin>
