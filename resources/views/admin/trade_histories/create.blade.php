<x-layouts.app>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Manually Add Trade History</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.trade-histories.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">User</label>
                <select name="user_id" class="w-full border rounded p-2" required>
                    <option value="">Select user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} (ID: {{ $user->id }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Trader</label>
                <select name="trader_id" class="w-full border rounded p-2" required>
                    <option value="">Select trader</option>
                    @foreach($traders as $trader)
                        <option value="{{ $trader->id }}">{{ $trader->name }} (ID: {{ $trader->id }})</option>
                    @endforeach
                </select>
            </div>

            <!--<div>
                <label class="block mb-1 font-medium">Trade</label>
                <select name="trade_id" class="w-full border rounded p-2" required>
                    <option value="">Select trade</option>
                    @foreach($trades as $trade)
                        <option value="{{ $trade->id }}">#{{ $trade->id }} | {{ $trade->created_at->format('Y-m-d') }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Amount Invested ($)</label>
                <input type="number" step="0.01" name="amount_invested" class="w-full border rounded p-2" required>
            </div>-->

            <div>
                <label class="block mb-1 font-medium">Symbol</label>
                <input type="string" name="symbol" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">ROI (%)</label>
                <input type="number" step="0.01" name="roi" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Amount Returned ($)</label>
                <input type="number" step="0.01" name="amount_returned" class="w-full border rounded p-2" required>
            </div>

            

            <!--<div>
                <label class="block mb-1 font-medium">New Trade Balance ($)</label>
                <input type="number" step="0.01" name="new_trade_balance" class="w-full border rounded p-2">
            </div>-->

            <div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Save Trade History
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
