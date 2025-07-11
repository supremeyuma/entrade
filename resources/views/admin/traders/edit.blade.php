<x-layouts.admin>
    <div class="px-4 py-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Trade for {{ $trade->trader->name }}</h1>

        <form action="{{ route('admin.trades.update', $trade) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-4">
                <label>Asset / Pair</label>
                <input type="text" name="asset" class="input" value="{{ old('asset', $trade->asset) }}" required>
            </div>

            <div class="mb-4">
                <label>Trade Type</label>
                <select name="trade_type" class="input" required>
                    <option value="buy" @selected($trade->trade_type === 'buy')>Buy</option>
                    <option value="sell" @selected($trade->trade_type === 'sell')>Sell</option>
                    <option value="long" @selected($trade->trade_type === 'long')>Long</option>
                    <option value="short" @selected($trade->trade_type === 'short')>Short</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label>Entry Price</label>
                    <input type="number" step="0.0001" name="entry_price" class="input" value="{{ old('entry_price', $trade->entry_price) }}">
                </div>
                <div>
                    <label>Exit Price</label>
                    <input type="number" step="0.0001" name="exit_price" class="input" value="{{ old('exit_price', $trade->exit_price) }}">
                </div>
                <div>
                    <label>Profit / Loss</label>
                    <input type="number" step="0.01" name="profit_loss" class="input" value="{{ old('profit_loss', $trade->profit_loss) }}">
                </div>
                <div>
                    <label>Status</label>
                    <select name="status" class="input">
                        <option value="open" @selected($trade->status === 'open')>Open</option>
                        <option value="closed" @selected($trade->status === 'closed')>Closed</option>
                        <option value="pending" @selected($trade->status === 'pending')>Pending</option>
                    </select>
                </div>
                <div>
                    <label>Opened At</label>
                    <input type="datetime-local" name="executed_at" class="input"
                           value="{{ old('executed_at', optional($trade->executed_at)->format('Y-m-d\TH:i')) }}">
                </div>
            </div>

            <button class="btn btn-primary mt-6">Update Trade</button>
        </form>
    </div>
</x-layouts.admin>
