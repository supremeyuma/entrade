@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
    $inputClasses = $isDark
        ? 'border-slate-700 bg-slate-800 text-slate-100 focus:border-emerald-400 focus:ring-emerald-500/20'
        : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-400 focus:ring-emerald-200';
@endphp

<x-layouts.app>
    <div class="mx-auto max-w-3xl px-4 py-6 sm:py-8">
        <div class="space-y-4 sm:space-y-6">
            <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                    <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Trading</p>
                    <h1 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Subscribe to {{ $trader->name }}</h1>
                    <p class="mt-2 text-sm {{ $bodyTextClasses }}">Trader ID: <span class="font-semibold">{{ $trader->trader_id }}</span></p>
                </div>
            </section>

            @if(session('success'))
                <div data-aos="fade-up" data-aos-delay="120" class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div data-aos="fade-up" data-aos-delay="130" class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
                    {{ session('error') }}
                    <a href="{{ route('user.deposit.create') }}" class="ml-1 font-semibold text-emerald-600 hover:underline dark:text-emerald-400">
                        Please make a new deposit to continue.
                    </a>
                </div>
            @endif

            @if(session('info'))
                <div data-aos="fade-up" data-aos-delay="140" class="rounded-2xl bg-sky-50 px-4 py-3 text-sm text-sky-700 dark:bg-sky-500/10 dark:text-sky-300">
                    {{ session('info') }}
                </div>
            @endif

            @if ($errors->any())
                <div data-aos="fade-up" data-aos-delay="150" class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div data-aos="fade-up" data-aos-delay="170" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
                <form action="{{ route('user.subscribe', $trader->id) }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="amount" class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">
                            Amount to Allocate
                        </label>
                        <input
                            type="number"
                            name="amount"
                            id="amount"
                            min="1"
                            value="{{ old('amount') }}"
                            required
                            class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}"
                            placeholder="Enter amount"
                        >
                    </div>

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]"
                    >
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
