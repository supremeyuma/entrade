<x-layouts.admin>
    <div class="px-4 py-6 max-w-3xl">
        <h1 class="text-2xl font-bold mb-4">Add Trade for {{ $trader->name }}</h1>

        <form method="POST" action="{{ route('admin.traders.trades.store', $trader) }}" class="space-y-4 bg-white dark:bg-gray-800 p-6 rounded shadow">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Asset</label>
                <input type="text" name="asset" required class="input w-full" placeholder="e.g., XAUUSD">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Pair (optional)</label>
                <input type="text" name="pair" class="input w-full" placeholder="e.g., EURUSD">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Trade Type</label>
                <select name="trade_type" class="input w-full" required>
                    <option value="buy">Buy</option>
                    <option value="sell">Sell</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Entry Price</label>
                    <input type="number" name="entry_price" step="0.0001" required class="input w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Exit Price</label>
                    <input type="number" name="exit_price" step="0.0001" required class="input w-full">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Lot Size</label>
                    <input type="number" name="lot_size" step="0.01" class="input w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Profit/Loss</label>
                    <input type="number" name="profit_loss" step="0.01" required class="input w-full">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Stop Loss</label>
                    <input type="number" name="stop_loss" step="0.0001" class="input w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Take Profit</label>
                    <input type="number" name="take_profit" step="0.0001" class="input w-full">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Opened At</label>
                    <input type="datetime-local" name="opened_at" class="input w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Closed At</label>
                    <input type="datetime-local" name="closed_at" class="input w-full">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Executed At</label>
                <input type="datetime-local" name="executed_at" required class="input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="input w-full" required>
                    <option value="closed">Closed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">Save Trade</button>
            </div>
        </form>
    </div>
</x-layouts.admin>
