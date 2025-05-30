<x-layouts/user>
<div class="container">
    <h1>Trade Outcome Details</h1>

    <div class="card mt-4">
        <div class="card-body">
            <h4>Trader Information</h4>
            <p><strong>Name:</strong> {{ $tradeOutcome->trader->name }}</p>
            <p><strong>Trader ID:</strong> {{ $tradeOutcome->trader->trader_id }}</p>
            <p><strong>Cumulative ROI:</strong> {{ number_format($cumulativeRoi, 2) }}%</p>

            <hr>

            <h4>Outcome Information</h4>
            <p><strong>Percentage Change:</strong> {{ $tradeOutcome->percentage_change }}%</p>
            <p><strong>Recorded At:</strong> {{ $tradeOutcome->created_at->format('M d, Y h:i A') }}</p>

            @if($tradeOutcome->notes)
                <p><strong>Notes:</strong> {{ $tradeOutcome->notes }}</p>
            @endif

            @if($userSubscription)
            <hr>
            <h4>Your Subscription Details</h4>
            <p><strong>Allocated Amount:</strong> ${{ number_format($userSubscription->allocated_amount, 2) }}</p>
            <p><strong>Subscribed Since:</strong> {{ $userSubscription->created_at->diffForHumans() }} ({{ $daysSubscribed }} days)</p>

            @php
                $gainLoss = ($tradeOutcome->percentage_change / 100) * $userSubscription->allocated_amount;
                $newBalance = $userSubscription->allocated_amount + $gainLoss;
            @endphp

            <p><strong>Gain/Loss:</strong> {{ $gainLoss >= 0 ? '+' : '' }}${{ number_format($gainLoss, 2) }}</p>
            <p><strong>Updated Allocation After Outcome:</strong> ${{ number_format($newBalance, 2) }}</p>
            @else
                <div class="alert alert-warning">You are not currently subscribed to this trader.</div>
            @endif

            <hr>

            <h4>Last 3 Trade Outcomes for This Trader</h4>
            @if($recentOutcomes->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Percentage Change</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOutcomes as $outcome)
                    <tr>
                        <td>{{ $outcome->created_at->format('M d, Y') }}</td>
                        <td>{{ $outcome->percentage_change }}%</td>
                        <td>{{ $outcome->notes ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p>No recent trade outcomes found.</p>
            @endif

            <a href="{{ route('user.trade.history') }}" class="btn btn-primary mt-3">Back to Trade History</a>
        </div>
    </div>
</div>
</x-layouts/user>
