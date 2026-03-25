<x-layouts/admin>
    @php
        $isDark = session('theme', 'light') === 'dark';
        $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-white' : 'border-slate-200 bg-white text-slate-900';
        $heroOverlayClasses = $isDark
            ? 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.18),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.18),_transparent_26%),linear-gradient(135deg,_#020617,_#0f172a_58%,_#111827)]'
            : 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
        $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
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
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Theme Settings</h1>
                    <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Configure the platform default theme and whether users can override it.</p>
                </div>
            </div>
        </section>

        @if (session('success'))
            <div data-aos="fade-up" data-aos-delay="70" class="rounded-[20px] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <section data-aos="fade-up" data-aos-delay="120" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <form method="POST" action="{{ route('admin.theme.settings.update') }}" class="space-y-4 sm:space-y-5">
                @csrf

                <div>
                    <label for="theme_default" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Default Theme</label>
                    <select class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" name="theme_default" id="theme_default">
                        <option value="light" {{ $defaultTheme === 'light' ? 'selected' : '' }}>Light</option>
                        <option value="dark" {{ $defaultTheme === 'dark' ? 'selected' : '' }}>Dark</option>
                        <option value="system" {{ $defaultTheme === 'system' ? 'selected' : '' }}>System Default</option>
                    </select>
                </div>

                <div>
                    <label for="allow_override" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Allow Users to Choose Their Own Theme?</label>
                    <select class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" name="allow_override" id="allow_override">
                        <option value="1" {{ $allowOverride === 'true' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ $allowOverride === 'false' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button class="inline-flex w-full items-center justify-center rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99] sm:w-auto" type="submit">
                        Save Settings
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-layouts/admin>
