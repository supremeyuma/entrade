<div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Activity Log</h2>
    @if ($logs->isEmpty())
        <p class="text-sm text-gray-500 dark:text-gray-400">No activity recorded yet.</p>
    @else
        <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            @foreach ($logs as $log)
                <li class="py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium">{{ ucfirst($log->action_type) }}</p>
                            <p class="text-gray-500 dark:text-gray-400">{{ $log->description }}</p>
                            @if (!empty($log->metadata))
                                <div class="text-xs mt-1 text-gray-400 dark:text-gray-500">
                                    {{ json_encode($log->metadata) }}
                                </div>
                            @endif
                            <span class="text-xs text-gray-400 dark:text-gray-500 block">
                                IP: {{ $log->ip_address }} <br>
                                Agent: {{ Str::limit($log->user_agent, 40) }}
                            </span>

                        </div>
                        <div class="text-right text-xs text-gray-400 dark:text-gray-500">
                            {{ $log->created_at->diffForHumans() }}
                        </div>

                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    @if ($logs->hasPages())
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    @endif
</div>
