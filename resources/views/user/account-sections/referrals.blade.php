<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6 space-y-4 sm:space-y-6">
    <h2 class="text-lg font-semibold sm:text-xl">Referral Settings</h2>

    @if(session('referral_success'))
        <div class="bg-green-100 text-green-800 dark:bg-green-700 dark:text-white px-4 py-3 rounded">
            {{ session('referral_success') }}
        </div>
    @endif

    <!-- Referral Link -->
    <div>
        <label class="block text-sm font-medium mb-1">Your Referral Link</label>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:space-x-2">
            <input type="text" readonly value="{{ route('register', ['ref' => $user->referral_code]) }}"
                   class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white sm:px-4">
            <button type="button"
                    x-data="{}"
                    @click="navigator.clipboard.writeText('{{ route('register', ['ref' => $user->referral_code]) }}')"
                    class="w-full rounded bg-blue-600 px-3 py-2 text-sm text-white transition hover:bg-blue-700 sm:w-auto">
                Copy
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-gray-100 dark:bg-gray-700 rounded p-4">
            <p class="text-sm text-gray-600 dark:text-gray-300">Total Referrals</p>
            <p class="text-lg font-semibold">{{ $user->referrals()->count() }}</p>
        </div>
        <div class="bg-gray-100 dark:bg-gray-700 rounded p-4">
            <p class="text-sm text-gray-600 dark:text-gray-300">Total Bonus Earned</p>
            <p class="text-lg font-semibold">${{ number_format($user->referrals()->sum('bonus'), 2) }}</p>
        </div>
    </div>

    <a href="{{ route('user.referrals.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">
        View my full referral history
    </a>
</div>
