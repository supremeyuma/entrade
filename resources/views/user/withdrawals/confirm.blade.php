<x-layouts.app>
    <div class="max-w-xl mx-auto px-4 py-6 sm:py-10">
        <h2 class="mb-4 text-xl font-bold text-gray-800 dark:text-white sm:mb-6 sm:text-2xl">Confirm Withdrawal</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-800 p-4 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded shadow p-4 sm:p-6 space-y-3 sm:space-y-4 text-sm">
            <div><strong>Cryptocurrency:</strong> {{ $withdrawal->cryptocurrency }}</div>
            <div><strong>Amount:</strong> {{ $withdrawal->amount }}</div>
            <div><strong>Network:</strong> {{ $withdrawal->network ?? 'N/A' }}</div>
            <div><strong>To:</strong> {{ $withdrawal->wallet_address }}</div>
            <div><strong>Fee:</strong> {{ $withdrawal->fee }}</div>
            <div><strong>Net Amount:</strong> {{ $withdrawal->amount - $withdrawal->fee }}</div>
        </div>

        <form action="{{ route('user.withdrawals.confirm.process') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $withdrawal->confirmation_token }}">

            @if ($withdrawal->user->two_factor_secret)
                <div>
                    <label class="block font-medium mb-1">2FA Code</label>
                    <input type="text" name="code"
                        class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                </div>
            @else
                <div class="text-yellow-600 dark:text-yellow-400 text-sm">
                    You do not have 2FA enabled. Click confirm to proceed.
                </div>
            @endif

            <div class="flex justify-end">
                <button class="w-full rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700 sm:w-auto">Confirm Withdrawal</button>
            </div>
        </form>
    </div>
</x-layouts.app>
