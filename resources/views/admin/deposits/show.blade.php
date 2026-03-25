<x-layouts.admin>
    <div class="px-4 py-6">
        <h1 class="mb-4 text-xl font-bold text-gray-900 dark:text-white sm:mb-6 sm:text-2xl">Deposit #{{ $deposit->id }}</h1>

        <div class="max-w-2xl rounded-xl bg-white p-4 shadow dark:bg-gray-800 sm:p-6">
            <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                <div class="flex justify-between py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">User</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $deposit->user->name ?? '—' }}<br/><span class="text-xs text-gray-500">{{ $deposit->user->email ?? '' }}</span></dd>
                </div>
                <div class="flex justify-between py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Date</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $deposit->created_at->format('M d, Y H:i:s') }}</dd>
                </div>
                <div class="flex justify-between py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Amount</dt>
                    <dd class="text-gray-900 dark:text-gray-100">${{ number_format($deposit->amount,2) }}</dd>
                </div>
                <div class="flex justify-between py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Invoice</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $deposit->invoice_id }}</dd>
                </div>
                <div class="flex justify-between py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Status</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ ucfirst($deposit->status) }}</dd>
                </div>
                <div class="flex justify-between py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Received Amount</dt>
                    <dd class="text-gray-900 dark:text-gray-100">${{ number_format($deposit->received_amount ?? 0,2) }}</dd>
                </div>
                @if($deposit->admin_comment)
                <div class="flex justify-between py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Admin Comment</dt>
                    <dd class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $deposit->admin_comment }}</dd>
                </div>
                @endif
            </dl>

            @if($deposit->status !== 'finished')
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <form action="{{ route('admin.deposits.approve', $deposit->id) }}" method="POST" class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Received Amount (optional)</label>
                        <input type="number" step="0.01" name="received_amount" class="w-full rounded border px-3 py-2 mb-2" value="{{ old('received_amount', $deposit->received_amount ?? $deposit->amount) }}">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comment (optional)</label>
                        <textarea name="admin_comment" rows="3" class="w-full rounded border px-3 py-2 mb-2"></textarea>
                        <button class="w-full px-4 py-2 bg-green-600 text-white rounded">Approve & Credit</button>
                    </form>

                    <form action="{{ route('admin.deposits.reject', $deposit->id) }}" method="POST" class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rejection Reason (optional)</label>
                        <textarea name="admin_comment" rows="3" class="w-full rounded border px-3 py-2 mb-2"></textarea>
                        <button class="w-full px-4 py-2 bg-red-600 text-white rounded">Reject</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
