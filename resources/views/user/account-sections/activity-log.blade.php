<div class="rounded-[24px] border border-slate-200 bg-white p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:rounded-[28px] sm:p-6">
    <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-slate-100 sm:text-xl">Activity Log</h2>
    @if ($logs->isEmpty())
        <p class="text-sm text-slate-500 dark:text-slate-400">No activity recorded yet.</p>
    @else
        <ul class="divide-y divide-slate-200 text-sm dark:divide-slate-800">
            @foreach ($logs as $log)
                <li class="py-3">
                    <div class="flex flex-col gap-2 rounded-2xl px-3 py-3 transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-slate-50 dark:hover:bg-slate-800/80 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-medium text-slate-900 dark:text-slate-100">{{ ucfirst($log->action_type) }}</p>
                            <p class="text-slate-500 dark:text-slate-400">{{ $log->description }}</p>
                            @if (!empty($log->metadata))
                                <div class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                                    {{ json_encode($log->metadata) }}
                                </div>
                            @endif
                            <span class="block text-xs text-slate-400 dark:text-slate-500">
                                IP: {{ $log->ip_address }} <br>
                                Agent: {{ Str::limit($log->user_agent, 40) }}
                            </span>
                        </div>
                        <div class="text-right text-xs text-slate-400 dark:text-slate-500">
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
