<x-layouts.app>
<div class="container">
    <h1>Trade History</h1>

    @if($histories->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Trader</th>
                    <th>Outcome (%)</th>
                    <th>Change</th>
                    <th>Previous Balance</th>
                    <th>New Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($histories as $history)
                    <tr>
                        <td>{{ $history->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $history->trader->name }}</td>
                        <td>{{ $history->tradeOutcome->percentage_change }}%</td>
                        <td>{{ number_format($history->change, 2) }}</td>
                        <td>{{ number_format($history->previous_balance, 2) }}</td>
                        <td>{{ number_format($history->new_balance, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $histories->links() }}
    @else
        <p>You have no trade history yet.</p>
    @endif
</div>
</x-layouts.app>
