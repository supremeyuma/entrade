<x-layouts.app>
    <div class="max-w-3xl mx-auto px-4 py-6 sm:px-6 sm:py-10 lg:px-8">
        <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-white sm:mb-6 sm:text-2xl">Deposit #{{ $deposit->id }}</h2>

        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow sm:p-6">
            <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Date</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $deposit->created_at->format('M d, Y H:i:s') }}</dd>
                </div>
                <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Amount</dt>
                    <dd class="text-gray-900 dark:text-gray-100">${{ number_format($deposit->amount,2) }}</dd>
                </div>
                <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Currency</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ strtoupper($deposit->currency) }}</dd>
                </div>
                <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Status</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ ucfirst($deposit->status) }}</dd>
                </div>
                <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Invoice</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $deposit->invoice_id }}</dd>
                </div>
                @if($deposit->admin_comment)
                <div class="py-3">
                    <dt class="font-medium text-gray-700 dark:text-gray-300">Admin Comment</dt>
                    <dd class="text-gray-900 dark:text-gray-100 mt-2 whitespace-pre-wrap">{{ $deposit->admin_comment }}</dd>
                </div>
                @endif
            </dl>
        </div>
    </div>
</x-layouts.app>
