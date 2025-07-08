<x-layouts.admin>
    <div class="px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

        {{-- KPI Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                <h2 class="text-sm text-gray-500">Total Users</h2>
                <p class="mt-1 text-3xl font-semibold text-blue-600">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                <h2 class="text-sm text-gray-500">Admins</h2>
                <p class="mt-1 text-3xl font-semibold text-indigo-500">{{ $admins }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                <h2 class="text-sm text-gray-500">Verified Traders</h2>
                <p class="mt-1 text-3xl font-semibold text-green-500">{{ $traders }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                <h2 class="text-sm text-gray-500">Pending Withdrawals</h2>
                <p class="mt-1 text-3xl font-semibold text-red-500">{{ $pendingWithdrawals }}</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-8 flex flex-wrap gap-4">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Manage Users</a>
            <a href="{{ route('admin.traders.index') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Manage Traders</a>
            <a href="{{ route('admin.withdrawals.index') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Review Withdrawals</a>
            <a href="{{ route('admin.trades.create') }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Add Manual Trade</a>
        </div>

        {{-- Recent Activity --}}
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Recent Trades</h2>
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
                <table class="w-full table-auto text-left text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                        <tr>
                            <th class="px-4 py-2">Trader</th>
                            <th class="px-4 py-2">Pair</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Result</th>
                            <th class="px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentTrades as $trade)
                            <tr class="border-t dark:border-gray-700">
                                <td class="px-4 py-2">{{ $trade->trader->name }}</td>
                                <td class="px-4 py-2">{{ $trade->pair }}</td>
                                <td class="px-4 py-2">{{ ucfirst($trade->type) }}</td>
                                <td class="px-4 py-2 {{ $trade->profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $trade->profit }} USD
                                </td>
                                <td class="px-4 py-2">{{ $trade->created_at->format('d M, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-4 text-center text-gray-500">No recent trades</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
