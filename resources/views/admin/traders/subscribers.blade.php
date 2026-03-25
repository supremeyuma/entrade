<x-layouts.admin>
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-100 sm:mb-6 sm:text-2xl">
            Subscribers for {{ $trader->name }}
        </h1>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Subscribed At</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Allocated Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($subscribers as $subscription)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                {{ $subscription->user->name }}<br>
                                <span class="text-xs text-gray-500 dark:text-gray-400">(ID: {{ $subscription->user->id }})</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $subscription->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                ${{ number_format($subscription->allocated_amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $subscribers->links() }}
        </div>
    </div>
</x-layouts.admin>
