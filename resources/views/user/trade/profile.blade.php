<x-layouts.app>
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <h1 class="text-3xl font-bold mb-4">{{ $trader->name }} (ID: {{ $trader->trader_id }})</h1>

    
    <div class="mb-6">
        <p class="mb-2"><strong>Bio:</strong> {{ $trader->bio ?? 'No bio available.' }}</p>
        <p><strong>Total Trades:</strong> {{ $trader->trades_count }}</p>
        <p><strong>Subscribers:</strong> {{ $trader->subscriptions_count }}</p>
        <p><strong>ROI:</strong> {{ number_format($trader->roi, 2) }}%</p>
        <p><strong>Win Rate:</strong> {{ number_format($trader->win_rate, 2) }}%</p>
    </div>

    <div class="mb-6">
        <canvas id="roiChart" height="150"></canvas>
    </div>

    @php
        $isSubscribed = $user->subscriptions->contains('trader_id', $trader->id);
    @endphp

    <div>
        @if(!$isSubscribed)
        <form action="{{ route('user.subscribe', $trader->id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="btn btn-primary">Copy This Trader</button>
        </form>

        @else
            <form method="POST" action="{{ route('user.unsubscribe', $trader->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to unsubscribe?')">Unsubscribe</button>
            </form>
        @endif
    </div>
</div>
<x-slot name="scripts">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('roiChart').getContext('2d');

    // Example data, replace with dynamic data passed from controller
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
                borderColor: 'rgb(37, 99, 235)',
                backgroundColor: 'rgba(37, 99, 235, 0.2)',
                fill: true,
                tension: 0.1,
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
