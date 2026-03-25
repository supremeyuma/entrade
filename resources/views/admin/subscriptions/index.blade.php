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
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Trader Subscription Requests</h1>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="w-full text-sm text-left">
                <thead class="{{ $subtleSurfaceClasses }} uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Trader</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @foreach($subscriptions as $sub)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-4 py-3 font-medium">{{ $sub->user->name }}</td>
                            <td class="px-4 py-3 {{ $mutedTextClasses }}">{{ $sub->trader->name }}</td>
                            <td class="px-4 py-3">${{ number_format($sub->allocated_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'pending_approval' => 'bg-amber-100 text-amber-800 dark:bg-amber-500/10 dark:text-amber-300',
                                        'active' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-300',
                                        'approved' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-300',
                                        'rejected' => 'bg-rose-100 text-rose-800 dark:bg-rose-500/10 dark:text-rose-300',
                                    ];
                                    $statusClass = $statusColors[$sub->status] ?? 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300';
                                @endphp
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ str_replace('_', ' ', ucfirst($sub->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.subscriptions.show', $sub->id) }}"
                                   class="inline-flex items-center rounded-2xl bg-sky-600 px-3 py-2 text-xs sm:text-sm font-medium text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">
                                    View
                                </a>
                                @if($sub->status === 'active')
                                    <form action="{{ route('admin.subscriptions.cancel', $sub->id) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this subscription?');">
                                        @csrf
                                        <button type="submit" class="ml-2 inline-flex items-center rounded-2xl bg-rose-600 px-3 py-2 text-xs sm:text-sm font-medium text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <div class="mt-6">
            {{ $subscriptions->links('pagination::tailwind') }}
        </div>
    </div>
</x-layouts.admin>
