<x-layouts.admin>
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
                <div class="relative flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                        <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Add Trade Log</h1>
                        <p class="mt-1 text-xs sm:text-sm {{ $mutedTextClasses }}">Record a win or loss entry with smaller controls designed for mobile admin use.</p>
                    </div>
                    <a href="{{ route('admin.trade-logs.index') }}" class="inline-flex items-center justify-center rounded-2xl border px-4 py-2 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $isDark ? 'border-slate-700 bg-slate-900/80 text-slate-100 hover:bg-slate-800' : 'border-slate-300 bg-white/80 text-slate-900 hover:bg-slate-50' }}">
                        Back to Logs
                    </a>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="120" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <form action="{{ route('admin.trade-logs.store') }}" method="POST" class="space-y-4 sm:space-y-5">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="trader_id" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Trader</label>
                        <select name="trader_id" id="trader_id" required class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                            <option value="">Select Trader</option>
                            @foreach ($traders as $trader)
                                <option value="{{ $trader->id }}" {{ old('trader_id') == $trader->id ? 'selected' : '' }}>{{ $trader->name }}</option>
                            @endforeach
                        </select>
                        @error('trader_id')
                            <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="entry_date" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Entry Date</label>
                        <input type="date" name="entry_date" id="entry_date" value="{{ old('entry_date') }}" required class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                        @error('entry_date')
                            <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="result" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Result</label>
                        <select name="result" id="result" required class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}">
                            <option value="win" {{ old('result') === 'win' ? 'selected' : '' }}>Win</option>
                            <option value="loss" {{ old('result') === 'loss' ? 'selected' : '' }}>Loss</option>
                        </select>
                        @error('result')
                            <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="percentage_change" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Percentage Change (%)</label>
                        <input type="number" step="0.01" name="percentage_change" id="percentage_change" value="{{ old('percentage_change') }}" required class="w-full rounded-2xl border px-3 py-2.5 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" placeholder="e.g. 8.50 or -3.00">
                        @error('percentage_change')
                            <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="notes" class="mb-1.5 block text-sm font-medium {{ $headingClasses }}">Notes</label>
                    <textarea name="notes" id="notes" rows="4" class="w-full rounded-[22px] border px-3 py-3 text-sm shadow-sm transition focus:outline-none focus:ring-2 {{ $inputClasses }}" placeholder="Optional notes about this trade log.">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-xs font-medium text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.trade-logs.index') }}" class="inline-flex items-center justify-center rounded-2xl border px-4 py-2.5 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-lg active:scale-[0.99] {{ $isDark ? 'border-slate-700 bg-slate-800 text-slate-100 hover:bg-slate-700' : 'border-slate-300 bg-white text-slate-900 hover:bg-slate-50' }}">
                        Cancel
                    </a>
                    <button class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">
                        Create Log
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-layouts.admin>
