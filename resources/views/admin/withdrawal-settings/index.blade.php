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
            ? 'border-slate-700 bg-slate-800 text-slate-100 placeholder:text-slate-500 focus:border-emerald-400 focus:ring-emerald-500/20'
            : 'border-slate-200 bg-slate-50 text-slate-900 placeholder:text-slate-400 focus:border-emerald-400 focus:ring-emerald-200';
    @endphp

    <div class="space-y-3 sm:space-y-6">
        <section data-aos="fade-up" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative">
                    <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Withdrawal Fee Settings</h1>
                    <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Manage per-asset fee rules with smaller form controls and a clearer settings table.</p>
                </div>
            </div>
        </section>

        @if (session('success'))
            <div data-aos="fade-up" data-aos-delay="70" class="rounded-[20px] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <section data-aos="fade-up" data-aos-delay="120" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <form method="POST" action="{{ route('admin.withdrawal-settings.store') }}" class="space-y-4">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
                    <div>
                        <label for="cryptocurrency" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Crypto</label>
                        <input id="cryptocurrency" name="cryptocurrency" value="{{ old('cryptocurrency') }}" placeholder="e.g. BTC" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" required>
                    </div>
                    <div>
                        <label for="min_amount" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Min</label>
                        <input id="min_amount" name="min_amount" value="{{ old('min_amount') }}" placeholder="0.00" type="number" step="any" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" required>
                    </div>
                    <div>
                        <label for="max_amount" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Max</label>
                        <input id="max_amount" name="max_amount" value="{{ old('max_amount') }}" placeholder="0.00" type="number" step="any" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" required>
                    </div>
                    <div>
                        <label for="fixed_fee" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Fixed Fee</label>
                        <input id="fixed_fee" name="fixed_fee" value="{{ old('fixed_fee') }}" placeholder="0.00" type="number" step="any" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" required>
                    </div>
                    <div>
                        <label for="percent_fee" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Percent Fee</label>
                        <input id="percent_fee" name="percent_fee" value="{{ old('percent_fee') }}" placeholder="0.00" type="number" step="any" class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" required>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button class="inline-flex w-full items-center justify-center rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99] sm:w-auto">
                        Save
                    </button>
                </div>
            </form>
        </section>

        <section data-aos="fade-up" data-aos-delay="180" class="overflow-x-auto rounded-[20px] sm:rounded-[28px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <table class="min-w-full text-sm">
                <thead class="{{ $subtleSurfaceClasses }}">
                    <tr class="uppercase text-[11px] tracking-[0.16em]">
                        <th class="px-3 py-2.5 sm:px-4">Crypto</th>
                        <th class="px-3 py-2.5 sm:px-4">Min</th>
                        <th class="px-3 py-2.5 sm:px-4">Max</th>
                        <th class="px-3 py-2.5 sm:px-4">Fixed</th>
                        <th class="px-3 py-2.5 sm:px-4">Percent</th>
                    </tr>
                </thead>
                <tbody class="{{ $headingClasses }}">
                    @forelse ($settings as $setting)
                        <tr class="border-t border-slate-200 transition duration-300 ease-out hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800/70">
                            <td class="px-3 py-3 font-semibold sm:px-4">{{ $setting->cryptocurrency }}</td>
                            <td class="px-3 py-3 sm:px-4 {{ $mutedTextClasses }}">{{ $setting->min_amount }}</td>
                            <td class="px-3 py-3 sm:px-4 {{ $mutedTextClasses }}">{{ $setting->max_amount }}</td>
                            <td class="px-3 py-3 sm:px-4 {{ $mutedTextClasses }}">{{ $setting->fixed_fee }}</td>
                            <td class="px-3 py-3 sm:px-4 {{ $mutedTextClasses }}">{{ $setting->percent_fee }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm {{ $mutedTextClasses }}">No withdrawal settings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
</x-layouts.admin>
