@extends('layouts.user')

@section('content')
<div class="container">
    <h2>My Copied Traders</h2>

    <div class="mb-4">
        <p>Main Balance: {{ number_format($user->main_balance, 2) }}</p>
        <p>Trading Balance: {{ number_format($user->trading_balance, 2) }}</p>
    </div>

    @if($subscriptions->isEmpty())
        <p>You are not copying any traders yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Trader Name</th>
                    <th>Trader ID</th>
                    <th>Allocated Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($subscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->trader->name }}</td>
                    <td>{{ $subscription->trader->trader_id }}</td>
                    <td>{{ number_format($subscription->amount_allocated, 2) }}</td>
                    <td>
                        <!-- Update Allocation Form -->
                        <form action="{{ route('user.updateAllocation', $subscription->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="number" name="new_amount" placeholder="New Amount" required>
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>

                        <!-- Unsubscribe Button -->
                        <form action="{{ route('user.unsubscribe', $subscription->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Unsubscribe</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif
</div>
@endsection
