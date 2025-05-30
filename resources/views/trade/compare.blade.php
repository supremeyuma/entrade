<x-layouts/app>
<div class="container">
    <h1>Trader Comparison</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($traders as $trader)
        <div class="card mb-3">
            <div class="card-body">
                <h4>{{ $trader->name }} (ID: {{ $trader->trader_id }})</h4>
                <p>ROI: {{ $trader->roi }}%</p>
                <p>Win Rate: {{ $trader->win_rate }}%</p>
                <p>Subscribers: {{ $trader->subscribers_count }}</p>
                <p>{{ Str::limit($trader->bio, 100) }}</p>
                <a href="{{ route('traders.show', $trader->id) }}" class="btn btn-primary">View Profile</a>
                <form method="POST" action="{{ route('traders.removeFromCompare', $trader->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Remove from Compare</button>
                </form>
            </div>
        </div>
    @endforeach

    <h3>Performance Comparison Chart</h3>
    <canvas id="compareChart" width="400" height="200"></canvas>
</div>
<x-slot name="scripts">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('compareChart').getContext('2d');
const compareChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'], // replace with real time labels
        datasets: {!! json_encode($chartData) !!}
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'ROI Over Time'
            }
        }
    }
});
</script>
</x-slot>
</x-layouts/app>
