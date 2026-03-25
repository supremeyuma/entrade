@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
    $mutedTextClasses = $isDark ? 'text-slate-400' : 'text-slate-500';
    $inputClasses = $isDark
        ? 'border-slate-700 bg-slate-800 text-slate-100 placeholder:text-slate-500 focus:border-emerald-400 focus:ring-emerald-500/20'
        : 'border-slate-200 bg-slate-50 text-slate-900 placeholder:text-slate-400 focus:border-emerald-400 focus:ring-emerald-200';
@endphp

<x-layouts.app>
    <div class="mx-auto max-w-5xl px-4 py-6 sm:py-8">
        <div class="space-y-4 sm:space-y-6">
            <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                    <div class="pointer-events-none absolute -right-10 top-6 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl animate-pulse"></div>
                    <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $mutedTextClasses }}">Trading</p>
                    <h1 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Find a Trader</h1>
                    <p class="mt-2 text-sm {{ $bodyTextClasses }}">Search by trader name or ID, then start copying directly from the result.</p>
                </div>
            </section>

            @if(session('error'))
                <div data-aos="fade-up" data-aos-delay="120" class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
                    {{ session('error') }}
                </div>
            @endif

            <section data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
                <form action="{{ route('user.trade.search') }}" method="GET">
                    <div class="flex flex-col items-stretch gap-3 sm:flex-row sm:items-center sm:gap-4">
                        <label for="search" class="sr-only">Search Trader</label>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            class="w-full rounded-2xl border px-4 py-2 text-sm transition focus:outline-none focus:ring-2 sm:w-2/3 sm:px-5 sm:py-3 {{ $inputClasses }}"
                            placeholder="Enter trader name or ID"
                            required
                        >
                        <button type="submit"
                                class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
                            Search
                        </button>
                    </div>
                </form>
            </section>

            @if(isset($traders) && $traders->count() > 0)
                <h2 data-aos="fade-up" data-aos-delay="170" class="text-lg font-semibold {{ $headingClasses }} sm:text-xl">Search Results</h2>

                <div class="space-y-4">
                    @foreach($traders as $trader)
                        <div data-aos="fade-up" data-aos-delay="220" class="flex flex-col items-start justify-between gap-3 rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:flex-row sm:items-center sm:p-5 {{ $surfaceClasses }}">
                            <div>
                                <h3 class="text-lg font-semibold {{ $headingClasses }}">{{ $trader->name }}</h3>
                                <p class="text-sm {{ $bodyTextClasses }}">Trader ID: {{ $trader->trader_id }}</p>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2 sm:mt-0">
                                @if (!$user->subscriptions->contains('trader_id', $trader->id))
                                    <a href="{{ route('user.trade.showSubscribeForm', $trader->id) }}"
                                       class="rounded-2xl bg-emerald-600 px-3 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">
                                        Copy Trader
                                    </a>
                                @else
                                    <span class="rounded-2xl bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                                        Subscribed
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif(isset($traders))
                <p data-aos="fade-up" data-aos-delay="170" class="rounded-[24px] border p-5 text-sm shadow-sm {{ $surfaceClasses }} {{ $bodyTextClasses }}">No traders found.</p>
            @endif
        </div>
    </div>
</x-layouts.app>
