<x-layouts/app>
<h1>{{ $trader->name }} ({{ $trader->trader_id }})</h1>
    <p>ROI: {{ $trader->roi }}%</p>
    <p>Win Rate: {{ $trader->win_rate }}%</p>
    <p>Total Subscribers: {{ $trader->subscriptions_count }}</p>
    <p>Total Trades: {{ $trader->trades_count }}</p>

    <a href="{{ route('user.subscribe', $trader->id) }}" class="btn btn-primary">Copy Trader</a>

    <form method="POST" action="{{ route('traders.addToCompare', $trader->id) }}">
        @csrf
        <button type="submit" class="btn btn-sm btn-secondary">Add to Compare</button>
    </form>

    <a href="{{ route('traders.compare') }}" class="btn btn-info">Compare Now</a>
</x-layouts/app>
