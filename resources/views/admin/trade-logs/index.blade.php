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
        <section data-aos="fade-up" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                        <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Trade Logs</h1>
                        <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Track win/loss entries in a denser, easier-to-scan admin table.</p>
                    </div>
                    <a href="{{ route('admin.trade-logs.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">
                        Add Trade Log
                    </a>
                </div>
            </div>
        </section>

        @if (session('success'))
            <div data-aos="fade-up" data-aos-delay="70" class="rounded-[20px] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <section data-aos="fade-up" data-aos-delay="130" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="min-w-full text-sm">
                <thead class="{{ $subtleSurfaceClasses }}">
                    <tr class="text-left uppercase text-[11px] tracking-[0.16em]">
                        <th class="px-3 py-2.5 sm:px-4">Trader</th>
                        <th class="px-3 py-2.5 sm:px-4">Date</th>
                        <th class="px-3 py-2.5 sm:px-4">Result</th>
                        <th class="px-3 py-2.5 sm:px-4">Change</th>
                        <th class="px-3 py-2.5 sm:px-4">Notes</th>
                        <th class="px-3 py-2.5 sm:px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @forelse ($tradeLogs as $log)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-3 sm:px-4">
                                <p class="font-semibold">{{ $log->trader->name }}</p>
                                <p class="text-xs {{ $mutedTextClasses }}">{{ $log->trader->trader_id ?? 'No trader ID' }}</p>
                            </td>
                            <td class="px-3 py-3 text-xs sm:px-4 sm:text-sm {{ $mutedTextClasses }}">{{ $log->entry_date->format('Y-m-d') }}</td>
                            <td class="px-3 py-3 sm:px-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $log->result === 'win' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-300' }}">
                                    {{ ucfirst($log->result) }}
                                </span>
                            </td>
                            <td class="px-3 py-3 sm:px-4 font-semibold {{ $log->percentage_change >= 0 ? 'text-emerald-600 dark:text-emerald-300' : 'text-rose-600 dark:text-rose-300' }}">
                                {{ $log->percentage_change > 0 ? '+' : '' }}{{ $log->percentage_change }}%
                            </td>
                            <td class="px-3 py-3 text-xs sm:px-4 sm:text-sm {{ $mutedTextClasses }}">{{ \Illuminate\Support\Str::limit($log->notes, 50) ?: 'No notes' }}</td>
                            <td class="px-3 py-3 text-right sm:px-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.trade-logs.edit', $log) }}" class="inline-flex items-center rounded-2xl bg-amber-500 px-3 py-2 text-xs font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-amber-400 hover:shadow-lg active:scale-[0.99]">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.trade-logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-2xl bg-rose-600 px-3 py-2 text-xs font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm {{ $mutedTextClasses }}">No trade logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
</x-layouts.admin>
