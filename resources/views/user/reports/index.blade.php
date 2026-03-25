@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
@endphp

<x-layouts.app>
<div class="mx-auto max-w-3xl px-4 py-6 sm:py-8">
    <div class="space-y-4 sm:space-y-6">
        <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
            <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
            <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Reports</p>
                <h4 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Generate Report</h4>
                <p class="mt-2 text-sm {{ $bodyTextClasses }}">Choose the sections you want included, then download a consolidated report.</p>
            </div>
        </section>

        <form action="{{ route('user.reports.generate') }}" method="POST" data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
            @csrf
            <div class="space-y-3 text-sm {{ $bodyTextClasses }}">
                <label class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-800">
                    <input type="checkbox" name="sections[]" value="deposits" id="deposits" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span>Deposits</span>
                </label>
                <label class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-800">
                    <input type="checkbox" name="sections[]" value="withdrawals" id="withdrawals" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span>Withdrawals</span>
                </label>
                <label class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-800">
                    <input type="checkbox" name="sections[]" value="trades" id="trades" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span>Trades</span>
                </label>
                <label class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-800">
                    <input type="checkbox" name="sections[]" value="referrals" id="referrals" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span>Referrals</span>
                </label>
            </div>

            <div class="mt-4">
                <button class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">Download Report</button>
            </div>
        </form>
    </div>
</div>
</x-layouts.app>
