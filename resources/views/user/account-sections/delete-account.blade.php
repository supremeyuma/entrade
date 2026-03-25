<div class="space-y-4 rounded-[24px] border border-rose-200 bg-white p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-rose-500/20 dark:bg-slate-900 sm:rounded-[28px] sm:p-6">
    <h2 class="text-lg font-semibold text-rose-600 dark:text-rose-400 sm:text-xl">Delete Your Account</h2>

    <p class="text-sm text-slate-600 dark:text-slate-300">
        Deleting your account is irreversible. All your data, including trades, balances, and referrals, will be permanently deleted.
        Please enter your password to confirm.
    </p>

    @if (session('delete_success'))
        <div class="rounded-2xl bg-emerald-50 px-4 py-2 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
            {{ session('delete_success') }}
        </div>
    @endif

    @if ($errors->deleteAccount->any())
        <div class="rounded-2xl bg-rose-50 px-4 py-2 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
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
            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Confirm Password</label>
            <input type="password" name="password" id="password" required
                class="mt-1 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 transition focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-rose-400 dark:focus:ring-rose-500/20">
        </div>

        <button type="submit"
            onclick="return confirm('Are you sure you want to delete your account permanently?')"
            class="w-full rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
            Permanently Delete Account
        </button>
    </form>
</div>
