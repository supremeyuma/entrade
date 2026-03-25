@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $subtleSurfaceClasses = $isDark ? 'bg-slate-800/80 text-slate-400' : 'bg-slate-50 text-slate-500';
    $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
@endphp

<x-layouts.app>
<div class="mx-auto max-w-5xl px-4 py-6 sm:py-8">
    <div class="space-y-4 sm:space-y-6">
        <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
            <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
            <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Trading</p>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">{{ $trader->name }}</h1>
                <p class="mt-2 text-sm {{ $bodyTextClasses }}">Trader ID: {{ $trader->trader_id }}</p>
            </div>
        </section>

        <div data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
            <div class="grid grid-cols-1 gap-4 text-sm {{ $bodyTextClasses }} sm:grid-cols-2">
                <div><strong class="{{ $headingClasses }}">Bio:</strong> {{ $trader->bio ?? 'No bio available.' }}</div>
                <div><strong class="{{ $headingClasses }}">Total Trades:</strong> {{ $trader->trades_count }}</div>
                <div><strong class="{{ $headingClasses }}">Subscribers:</strong> {{ $trader->subscriptions_count }}</div>
                <div><strong class="{{ $headingClasses }}">ROI:</strong> {{ number_format($trader->roi, 2) }}%</div>
                <div><strong class="{{ $headingClasses }}">Win Rate:</strong> {{ number_format($trader->win_rate, 2) }}%</div>
            </div>
        </div>

        <div data-aos="fade-up" data-aos-delay="170" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
            <h2 class="mb-4 text-lg font-semibold {{ $headingClasses }}">ROI Trend</h2>
            <canvas id="roiChart" height="150"></canvas>
        </div>

        @php
            $isSubscribed = $user->subscriptions->contains('trader_id', $trader->id);
        @endphp

        <div data-aos="fade-up" data-aos-delay="220">
            @if(!$isSubscribed)
            <form action="{{ route('user.subscribe', $trader->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">Copy This Trader</button>
            </form>
            @else
                <form method="POST" action="{{ route('user.unsubscribe', $trader->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]" onclick="return confirm('Are you sure you want to unsubscribe?')">Unsubscribe</button>
                </form>
            @endif
        </div>
    </div>
</div>
<x-slot name="scripts">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('roiChart').getContext('2d');
    const roiData = @json($trader->roiHistory ?? []);
    const labels = roiData.map(item => item.date);
    const dataPoints = roiData.map(item => item.roi);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'ROI Over Time',
                data: dataPoints,
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgba(16, 185, 129, 0.15)',
                fill: true,
                tension: 0.2,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    display: true,
                    title: { display: true, text: 'Date' }
                },
                y: {
                    display: true,
                    title: { display: true, text: 'ROI (%)' }
                }
            }
        }
    });
</script>
</x-slot>
</x-layouts.app>
