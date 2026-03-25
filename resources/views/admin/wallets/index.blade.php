<x-layouts.admin>
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 sm:py-10 lg:px-8">
        <h2 class="mb-4 text-xl font-bold text-gray-800 dark:text-white sm:mb-6 sm:text-2xl">All User Wallets</h2>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                    <tr>
                        <th class="px-3 py-3 sm:px-6">User</th>
                        <th class="px-3 py-3 sm:px-6">Email</th>
                        <th class="px-3 py-3 sm:px-6">Crypto</th>
                        <th class="px-3 py-3 sm:px-6">Address</th>
                        <th class="px-3 py-3 sm:px-6">Network</th>
                        <th class="px-3 py-3 sm:px-6">Label</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($wallets as $wallet)
                        <tr>
                            <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->user->name }}</td>
                            <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->user->email }}</td>
                            <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->cryptocurrency }}</td>
                            <td class="px-3 py-3 sm:px-6 sm:py-4 break-words">{{ $wallet->wallet_address }}</td>
                            <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->network ?? '—' }}</td>
                            <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->label ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">No wallets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4">
                {{ $wallets->links() }}
            </div>
        </div>
    </div>
</x-layouts.admin>
