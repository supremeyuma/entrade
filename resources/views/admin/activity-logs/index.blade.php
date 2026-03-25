<x-layouts.admin>
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-100 sm:mb-6 sm:text-2xl">Activity Logs</h1>

        {{-- Filter Form --}}
        <form method="GET" class="mb-4 grid grid-cols-1 gap-3 sm:mb-6 sm:grid-cols-3 sm:gap-4">
            <input
                type="text"
                name="user_id"
                placeholder="User ID"
                value="{{ request('user_id') }}"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white"
            >
            <input
                type="text"
                name="action_type"
                placeholder="Action Type"
                value="{{ request('action_type') }}"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white"
            >
            <button
                type="submit"
                class="inline-flex min-h-[40px] items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-indigo-700"
            >
                Filter
            </button>
        </form>

        {{-- Logs Table --}}
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Metadata</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $log->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $log->user?->name ?? 'System' }}</td>
                            <td class="px-4 py-3 text-sm text-indigo-600 dark:text-indigo-400 font-semibold">{{ $log->action_type }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $log->description }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ json_encode($log->metadata, JSON_PRETTY_PRINT) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-sm text-gray-500 dark:text-gray-400">No logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-layouts.admin>
