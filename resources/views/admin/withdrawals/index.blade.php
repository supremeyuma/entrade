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
                    <h2 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">User Withdrawals</h2>
                    <p class="mt-1 text-[11px] sm:mt-2 sm:text-sm {{ $mutedTextClasses }}">Review destinations, notes, fees, and update statuses quickly.</p>
                </div>
            </div>
        </section>

        @if (session('success'))
            <div data-aos="fade-up" data-aos-delay="100" class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">{{ session('success') }}</div>
        @endif

        <section data-aos="fade-up" data-aos-delay="140" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="min-w-full text-left text-sm">
                <thead class="{{ $subtleSurfaceClasses }}">
                    <tr>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">User</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Crypto</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Amount</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Fee</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">To</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Status</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @foreach ($withdrawals as $withdrawal)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $withdrawal->user->name }}</td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $withdrawal->cryptocurrency }}</td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $withdrawal->amount }}</td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $withdrawal->fee }}</td>
                            <td class="truncate px-3 py-2 sm:px-4 sm:py-3">{{ $withdrawal->wallet_address }}</td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3">{{ ucfirst($withdrawal->status) }}</td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3">
                                <form method="POST" action="{{ route('admin.withdrawals.update', $withdrawal) }}" class="grid gap-2">
                                    @csrf @method('PUT')
                                    <select name="status" class="rounded-2xl border px-3 py-2 text-xs sm:text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                                        @foreach (['unconfirmed', 'pending', 'approved', 'rejected', 'completed', 'cancelled'] as $status)
                                            <option value="{{ $status }}" {{ $withdrawal->status === $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="admin_note" value="{{ $withdrawal->admin_note }}" placeholder="Note"
                                           class="rounded-2xl border px-3 py-2 text-xs sm:text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                                    <button type="submit"
                                        class="rounded-2xl bg-sky-600 px-3 py-2 text-xs sm:text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $withdrawals->links() }}
            </div>
        </section>
    </div>
</x-layouts.admin>
