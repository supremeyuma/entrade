<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6 space-y-4">
    <h2 class="text-lg font-semibold text-red-600 sm:text-xl">Delete Your Account</h2>

    <p class="text-sm text-gray-600 dark:text-gray-300">
        Deleting your account is irreversible. All your data, including trades, balances, and referrals, will be permanently deleted. 
        Please enter your password to confirm.
    </p>

    @if (session('delete_success'))
        <div class="bg-green-100 text-green-800 dark:bg-green-700 dark:text-white px-4 py-2 rounded">
            {{ session('delete_success') }}
        </div>
    @endif

    @if ($errors->deleteAccount->any())
        <div class="bg-red-100 text-red-800 dark:bg-red-700 dark:text-white px-4 py-2 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->deleteAccount->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('user.account.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium">Confirm Password</label>
            <input type="password" name="password" id="password" required
                   class="mt-1 block w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
        </div>

        <button type="submit"
                onclick="return confirm('Are you sure you want to delete your account permanently?')"
                class="w-full rounded bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700 sm:w-auto">
            Permanently Delete Account
        </button>
    </form>
</div>
