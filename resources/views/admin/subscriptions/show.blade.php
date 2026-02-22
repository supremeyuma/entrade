<x-layouts.admin>
    <div class="px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
            Subscription Request
        </h1>

        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 max-w-2xl">
            {{-- Request Details --}}
            <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                <div class="flex justify-between py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">User</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $subscription->user->name }}</dd>
                </div>
                <div class="flex justify-between py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Trader</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $subscription->trader->name }}</dd>
                </div>
                <div class="flex justify-between py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Amount</dt>
                    <dd class="text-gray-900 dark:text-gray-100">
                        ${{ number_format($subscription->allocated_amount, 2) }}
                    </dd>
                </div>
                <div class="flex justify-between py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Status</dt>
                    <dd>
                        @php
                            $statusColors = [
                                'pending_approval' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300',
                                'active' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300',
                                'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300',
                                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300',
                            ];
                            $statusClass = $statusColors[$subscription->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/40 dark:text-gray-300';
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $subscription->status)) }}
                        </span>
                    </dd>
                </div>
            </dl>

            {{-- Approval/Reject Forms --}}
            @if($subscription->status === 'pending_approval')
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Approve Form --}}
                    <form action="{{ route('admin.subscriptions.approve', $subscription->id) }}" method="POST" class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg shadow-sm">
                        @csrf
                        <label for="approve_comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Approval Comment (optional)
                        </label>
                        <textarea
                            name="admin_comment"
                            id="approve_comment"
                            rows="3"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-green-500 focus:border-green-500 text-sm"
                        ></textarea>
                        <button
                            type="submit"
                            class="mt-3 w-full inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        >
                            Approve
                        </button>
                    </form>

                    {{-- Reject Form --}}
                    <form action="{{ route('admin.subscriptions.reject', $subscription->id) }}" method="POST" class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg shadow-sm">
                        @csrf
                        <label for="reject_comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Rejection Reason (optional)
                        </label>
                        <textarea
                            name="admin_comment"
                            id="reject_comment"
                            rows="3"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-red-500 focus:border-red-500 text-sm"
                        ></textarea>
                        <button
                            type="submit"
                            class="mt-3 w-full inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                            Reject
                        </button>
                    </form>
                </div>
            @elseif($subscription->status === 'active')
                {{-- Cancel Active Subscription --}}
                <div class="mt-6 bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg shadow-sm">
                    <form action="{{ route('admin.subscriptions.cancel', $subscription->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this subscription?');">
                        @csrf
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                            Cancelling this subscription will refund the allocated amount to the user's main balance.
                        </p>
                        <button
                            type="submit"
                            class="w-full inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                        >
                            Cancel Subscription
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
