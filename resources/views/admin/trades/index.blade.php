<x-layouts.admin>
<div class="space-y-3 sm:space-y-6">
    <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border border-slate-200 bg-white text-slate-900 shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl dark:border-slate-800 dark:bg-slate-950 dark:text-white">
        <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)] dark:bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.18),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.18),_transparent_26%),linear-gradient(135deg,_#020617,_#0f172a_58%,_#111827)]"></div>
            <div class="relative"><p class="text-[11px] font-medium uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400 sm:tracking-[0.24em]">Admin</p><h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl">Trade Logs</h1></div>
        </div>
    </section>

    <a href="{{ route('admin.trade-logs.create') }}" class="inline-flex rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">Add Trade</a>

    <section data-aos="fade-up" data-aos-delay="120" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border border-slate-200 bg-white shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
        <table class="min-w-full leading-normal text-sm">
            <thead class="bg-slate-50 text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                <tr><th class="px-6 py-3 text-left">Trader</th><th class="px-6 py-3 text-left">Date</th><th class="px-6 py-3 text-left">Symbol</th><th class="px-6 py-3 text-left">ROI %</th><th class="px-6 py-3 text-left">Opened</th><th class="px-6 py-3 text-left">Closed</th></tr>
            </thead>
            <tbody class="text-slate-900 dark:text-slate-100">
                @foreach ($trades as $trade)
                    <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                        <td class="px-6 py-4">{{ $trade->trader->name }}</td>
                        <td class="px-6 py-4">{{ $trade->created_at }}</td>
                        <td class="px-6 py-4">{{ $trade->symbol }}</td>
                        <td class="px-6 py-4">{{ $trade->roi }}%</td>
                        <td class="px-6 py-4">{{ $trade->entry_timestamp }}</td>
                        <td class="px-6 py-4"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>
</x-layouts.admin>
