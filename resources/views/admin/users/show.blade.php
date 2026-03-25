<x-layouts.admin>
    <div class="px-4 py-6">
        <h1 class="mb-4 text-xl font-bold sm:text-2xl">User Profile</h1>


        <div class="bg-white dark:bg-gray-800 rounded shadow space-y-4 p-4 sm:p-6">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->roles->pluck('name')->implode(', ') ?: 'No role' }}</p>
            <p><strong>Status:</strong> {{ $user->status ?? 'active' }}</p>
            <p><strong>Main Balance:</strong> ${{ number_format($user->balance->main_balance, 2) }}</p>
            <p><strong>Trading Balance:</strong> ${{ number_format($user->balance->trading_balance, 2) }}</p>
        </div>

        <a href="{{ route('admin.users.edit', $user) }}"
        class="mt-4 inline-block rounded bg-yellow-500 px-4 py-2 text-sm text-white hover:bg-yellow-600">
            Edit User
        </a>

        <a href="{{ route('admin.users.tradeHistories', $user) }}"
        class="mt-4 inline-block rounded bg-green-500 px-4 py-2 text-sm text-white hover:bg-yellow-600">
            View Trade History
        </a>



        <div class="mt-8">
            <h2 class="mb-4 text-lg font-semibold sm:text-xl">Transaction History</h2>
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
                <table class="w-full table-auto text-left text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                        <tr>
                            <th class="px-3 py-2 sm:px-4">Type</th>
                            <th class="px-3 py-2 sm:px-4">Balance</th>
                            <th class="px-3 py-2 sm:px-4">Category</th>
                            <th class="px-3 py-2 sm:px-4">Amount</th>
                            <th class="px-3 py-2 sm:px-4">User Note</th>
                            <th class="px-3 py-2 sm:px-4">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $tx)
                            <tr class="border-t dark:border-gray-700">
                                <td class="px-3 py-2 sm:px-4">{{ ucfirst($tx->type) }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ ucfirst($tx->balance_type) }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ ucfirst($tx->category) }}</td>
                                <td class="px-3 py-2 sm:px-4 {{ $tx->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                    ${{ number_format($tx->amount, 2) }}
                                </td>
                                <td class="px-3 py-2 sm:px-4">{{ $tx->user_note ?? '-' }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ $tx->created_at->format('d M, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-4 text-center text-gray-500">No transactions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
