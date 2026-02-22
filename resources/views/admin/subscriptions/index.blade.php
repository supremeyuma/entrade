<x-layouts.admin>
    <div class="px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
            Trader Subscription Requests
        </h1>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Trader</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($subscriptions as $sub)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">
                                {{ $sub->user->name }}
                            </td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                {{ $sub->trader->name }}
                            </td>
                            <td class="px-4 py-3 text-gray-900 dark:text-gray-200">
                                ${{ number_format($sub->allocated_amount, 2) }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'pending_approval' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300',
                                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300',
                                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300',
                                    ];
                                    $statusClass = $statusColors[$sub->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/40 dark:text-gray-300';
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                    {{ str_replace('_', ' ', ucfirst($sub->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.subscriptions.show', $sub->id) }}"
                                   class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    View
                                </a>
                                @if($sub->status === 'active')
                                    <form action="{{ route('admin.subscriptions.cancel', $sub->id) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this subscription?');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1 ml-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $subscriptions->links('pagination::tailwind') }}
        </div>
    </div>
</x-layouts.admin>
