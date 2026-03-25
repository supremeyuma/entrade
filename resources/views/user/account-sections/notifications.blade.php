<div class="space-y-4 rounded-[24px] border border-slate-200 bg-white p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:rounded-[28px] sm:p-6">
    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100 sm:text-xl">Notification History</h2>

    @if ($notifications->isEmpty())
        <p class="text-sm text-slate-500 dark:text-slate-300">You haven't received any notifications yet.</p>
    @else
        <ul class="divide-y divide-slate-200 dark:divide-slate-800">
            @foreach ($notifications as $notification)
                <li class="py-3">
                    <div class="flex flex-col gap-2 rounded-2xl px-3 py-3 transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-slate-50 dark:hover:bg-slate-800/80 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="font-medium text-slate-900 dark:text-slate-100">{{ $notification->data['title'] ?? 'Notification' }}</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                {{ $notification->data['message'] ?? '-' }}
                            </p>
                        </div>
                        <span class="whitespace-nowrap text-xs text-slate-400 dark:text-slate-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    @if ($notifications->hasPages())
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
