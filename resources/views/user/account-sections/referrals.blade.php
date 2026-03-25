<div x-data="{ copied: false }" class="space-y-4 rounded-[24px] border border-slate-200 bg-white p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:rounded-[28px] sm:p-6 sm:space-y-6">
    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100 sm:text-xl">Referral Settings</h2>

    @if(session('referral_success'))
        <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
            {{ session('referral_success') }}
        </div>
    @endif

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Your Referral Link</label>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:space-x-2">
            <input type="text" readonly value="{{ route('register', ['ref' => $user->referral_code]) }}"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 dark:border-slate-700 dark:bg-slate-800 dark:text-white sm:px-4 sm:py-3">
            <button type="button"
                    @click="navigator.clipboard.writeText('{{ route('register', ['ref' => $user->referral_code]) }}'); copied = true; setTimeout(() => copied = false, 1800)"
                    class="w-full rounded-2xl bg-emerald-600 px-3 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-4 sm:py-3">
                <span x-text="copied ? 'Copied' : 'Copy'"></span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div class="rounded-3xl bg-slate-50 p-4 dark:bg-slate-800">
            <p class="text-sm text-slate-600 dark:text-slate-300">Total Referrals</p>
            <p class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $user->referrals()->count() }}</p>
        </div>
        <div class="rounded-3xl bg-slate-50 p-4 dark:bg-slate-800">
            <p class="text-sm text-slate-600 dark:text-slate-300">Total Bonus Earned</p>
            <p class="text-lg font-semibold text-slate-900 dark:text-slate-100">${{ number_format($user->referrals()->sum('bonus'), 2) }}</p>
        </div>
    </div>

    <a href="{{ route('user.referrals.index') }}" class="inline-flex rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-slate-700 hover:shadow-lg dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-white">
        View my full referral history
    </a>
</div>
