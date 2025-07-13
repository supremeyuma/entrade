<x-layouts.admin>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6">User Withdrawals</h2>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded shadow overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Crypto</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Fee</th>
                        <th class="px-4 py-2">To</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($withdrawals as $withdrawal)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $withdrawal->user->name }}</td>
                            <td class="px-4 py-2">{{ $withdrawal->cryptocurrency }}</td>
                            <td class="px-4 py-2">{{ $withdrawal->amount }}</td>
                            <td class="px-4 py-2">{{ $withdrawal->fee }}</td>
                            <td class="px-4 py-2 truncate">{{ $withdrawal->wallet_address }}</td>
                            <td class="px-4 py-2">{{ ucfirst($withdrawal->status) }}</td>
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('admin.withdrawals.update', $withdrawal) }}">
                                    @csrf @method('PUT')
                                    <select name="status" class="rounded">
                                        @foreach (['pending', 'approved', 'rejected', 'completed'] as $status)
                                            <option value="{{ $status }}" {{ $withdrawal->status === $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="admin_note" value="{{ $withdrawal->admin_note }}" placeholder="Note"
                                           class="rounded border-gray-300 text-sm px-2">
                                    <button type="submit"
                                        class="text-xs bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $withdrawals->links() }}
            </div>
        </div>
    </div>
</x-layouts.admin>
