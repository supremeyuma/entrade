<x-layouts.admin>
    <div class="px-4 py-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">User: {{ $user->name }}</h1>

        {{-- Wallets --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Wallets</h2>
            <ul class="space-y-2">
                @foreach ($user->wallets as $wallet)
                    <li class="p-4 bg-white dark:bg-gray-800 rounded shadow">
                        <strong>{{ strtoupper($wallet->currency) }}</strong> —
                        {{ $wallet->balance }} {{ strtoupper($wallet->currency) }}
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Fund Management --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Adjust Funds</h2>

            <form action="{{ route('admin.funds.update', $user) }}" method="POST">
                @csrf
                @method('POST')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Wallet</label>
                        <select name="wallet_id" required class="w-full p-2 rounded border dark:bg-gray-900">
                            @foreach ($user->wallets as $wallet)
                                <option value="{{ $wallet->id }}">
                                    {{ strtoupper($wallet->currency) }} – Balance: {{ $wallet->balance }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Amount</label>
                        <input type="number" name="amount" step="0.01" required class="w-full p-2 rounded border dark:bg-gray-900" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Type</label>
                        <select name="type" required class="w-full p-2 rounded border dark:bg-gray-900">
                            <option value="credit">Credit (Add)</option>
                            <option value="debit">Debit (Subtract)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Category</label>
                        <select name="category" required class="w-full p-2 rounded border dark:bg-gray-900">
                            <option value="deposit">Deposit</option>
                            <option value="withdrawal">Withdrawal</option>
                            <option value="bonus">Bonus</option>
                            <option value="trade">Trade</option>
                            <option value="correction">Correction</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium mb-1">Note (Visible to User)</label>
                    <textarea name="note_user" rows="2" class="w-full p-2 rounded border dark:bg-gray-900"></textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium mb-1">Internal Note (Admin Only)</label>
                    <textarea name="note_admin" rows="2" class="w-full p-2 rounded border dark:bg-gray-900"></textarea>
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Submit Adjustment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
