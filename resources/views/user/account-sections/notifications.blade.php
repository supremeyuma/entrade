<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6 space-y-4">
    <h2 class="text-lg font-semibold sm:text-xl">Notification History</h2>

    @if ($notifications->isEmpty())
        <p class="text-sm text-gray-500 dark:text-gray-300">You haven't received any notifications yet.</p>
    @else
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($notifications as $notification)
                <li class="py-3">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="font-medium">{{ $notification->data['title'] ?? 'Notification' }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $notification->data['message'] ?? '-' }}
                            </p>
                        </div>
                        <span class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">
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
