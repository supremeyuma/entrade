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
    @endphp

    <div class="space-y-3 sm:space-y-6">
        <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative">
                    <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">User Profile</h1>
                    <p class="mt-1 text-[11px] sm:mt-2 sm:text-sm {{ $mutedTextClasses }}">Review balances, status, and recent transaction history for this account.</p>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="100" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <div class="grid grid-cols-1 gap-3 text-sm {{ $headingClasses }} md:grid-cols-2">
                <p><strong class="{{ $mutedTextClasses }}">Name:</strong> {{ $user->name }}</p>
                <p><strong class="{{ $mutedTextClasses }}">Email:</strong> {{ $user->email }}</p>
                <p><strong class="{{ $mutedTextClasses }}">Role:</strong> {{ $user->roles->pluck('name')->implode(', ') ?: 'No role' }}</p>
                <p><strong class="{{ $mutedTextClasses }}">Status:</strong> {{ $user->status ?? 'active' }}</p>
                <p><strong class="{{ $mutedTextClasses }}">Main Balance:</strong> ${{ number_format($user->balance->main_balance, 2) }}</p>
                <p><strong class="{{ $mutedTextClasses }}">Trading Balance:</strong> ${{ number_format($user->balance->trading_balance, 2) }}</p>
            </div>
        </section>

        <div class="flex flex-wrap gap-2" data-aos="fade-up" data-aos-delay="140">
            <a href="{{ route('admin.users.edit', $user) }}"
            class="inline-flex rounded-2xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-amber-400 hover:shadow-lg active:scale-[0.99]">
                Edit User
            </a>

            <a href="{{ route('admin.users.tradeHistories', $user) }}"
            class="inline-flex rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">
                View Trade History
            </a>
        </div>

        <section data-aos="fade-up" data-aos-delay="180" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <h2 class="mb-3 text-base sm:text-xl font-semibold {{ $headingClasses }}">Transaction History</h2>
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left text-sm">
                    <thead class="{{ $subtleSurfaceClasses }} uppercase">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Type</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Balance</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Category</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Amount</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">User Note</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody class="{{ $headingClasses }}">
                        @forelse ($transactions as $tx)
                            <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                                <td class="px-3 py-2 sm:px-4 sm:py-3">{{ ucfirst($tx->type) }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">{{ ucfirst($tx->balance_type) }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">{{ ucfirst($tx->category) }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3 {{ $tx->type === 'credit' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                    ${{ number_format($tx->amount, 2) }}
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $tx->user_note ?? '-' }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $tx->created_at->format('d M, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-4 text-center text-sm {{ $mutedTextClasses }}">No transactions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layouts.admin>
