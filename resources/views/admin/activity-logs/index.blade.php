<x-layouts.admin>
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="mb-4 text-xl font-semibold text-slate-800 dark:text-slate-100 sm:mb-6 sm:text-2xl">Activity Logs</h1>
        <form method="GET" class="mb-4 grid grid-cols-1 gap-3 sm:mb-6 sm:grid-cols-3 sm:gap-4">
            <input type="text" name="user_id" placeholder="User ID" value="{{ request('user_id') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            <input type="text" name="action_type" placeholder="Action Type" value="{{ request('action_type') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            <button type="submit" class="inline-flex min-h-[40px] items-center justify-center rounded-2xl bg-sky-600 px-4 py-2 text-sm font-medium text-white shadow transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">Filter</button>
        </form>
        <div class="overflow-x-auto rounded-[20px] bg-white shadow-sm dark:bg-slate-900">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 text-slate-700 dark:bg-slate-800 dark:text-slate-200"><tr><th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th><th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">User</th><th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th><th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Description</th><th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Metadata</th><th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Time</th></tr></thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/70">
                            <td class="px-4 py-3 text-sm text-slate-900 dark:text-slate-100">{{ $log->id }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">{{ $log->user?->name ?? 'System' }}</td>
                            <td class="px-4 py-3 text-sm font-semibold text-sky-600 dark:text-sky-400">{{ $log->action_type }}</td>
                            <td class="px-4 py-3 text-sm text-slate-800 dark:text-slate-200">{{ $log->description }}</td>
                            <td class="whitespace-pre-line px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ json_encode($log->metadata, JSON_PRETTY_PRINT) }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-3 text-center text-sm text-slate-500 dark:text-slate-400">No logs found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $logs->links() }}</div>
    </div>
</x-layouts.admin>
