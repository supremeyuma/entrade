<x-layouts/user>
<div class="container">
        <h1>Your Trader Subscriptions</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @foreach ($user->traderSubscriptions as $subscription)
            <div class="card mb-4">
                <div class="card-header">
                    <h5>{{ $subscription->trader->name }}</h5>
                    <p>Allocated Amount: {{ $subscription->allocated_amount }}</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.updateAllocation', $subscription->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="amount">Change Allocation</label>
                            <input type="number" name="amount" id="amount" class="form-control" value="{{ $subscription->allocated_amount }}" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Allocation</button>
                    </form>

                    <form action="{{ route('user.unsubscribe', $subscription->id) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-danger">Unsubscribe</button>
                    </form>
                </div>
            </div>
        @endforeach

        <h2>Transfer Funds Between Balances</h2>
        <form action="{{ route('user.transferFunds') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" min="1" required>
            </div>
            <div class="form-group">
                <label for="transfer_type">Transfer Type</label>
                <select name="transfer_type" id="transfer_type" class="form-control" required>
                    <option value="main_to_trade">Main to Trade</option>
                    <option value="trade_to_main">Trade to Main</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Transfer Funds</button>
        </form>
    </div>
</x-layouts/user>
