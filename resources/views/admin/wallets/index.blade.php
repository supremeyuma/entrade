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
                    <h2 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">All User Wallets</h2>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="min-w-full text-left text-sm">
                <thead class="{{ $subtleSurfaceClasses }} uppercase">
                    <tr>
                        <th class="px-3 py-3 sm:px-6">User</th>
                        <th class="px-3 py-3 sm:px-6">Email</th>
                        <th class="px-3 py-3 sm:px-6">Crypto</th>
                        <th class="px-3 py-3 sm:px-6">Address</th>
                        <th class="px-3 py-3 sm:px-6">Network</th>
                        <th class="px-3 py-3 sm:px-6">Label</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 {{ $headingClasses }}">
                    @forelse($wallets as $wallet)
                        <tr class="transition duration-300 ease-out hover:bg-slate-50 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->user->name }}</td>
                            <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->user->email }}</td>
                            <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->cryptocurrency }}</td>
                            <td class="break-words px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->wallet_address }}</td>
                            <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->network ?? '-' }}</td>
                            <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->label ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-sm {{ $mutedTextClasses }}">No wallets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4">
                {{ $wallets->links() }}
            </div>
        </section>
    </div>
</x-layouts.admin>
