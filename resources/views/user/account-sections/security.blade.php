{{-- resources/views/user/account-sections/security.blade.php --}}
<div class="space-y-6 rounded-[24px] border border-slate-200 bg-white p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:rounded-[28px] sm:p-6 sm:space-y-8">
    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100 sm:text-xl">Security Settings</h2>

    @if(session('security_success'))
        <div class="mb-4 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
            {{ session('security_success') }}
        </div>
    @endif

    @if($errors->security && $errors->security->any())
        <div class="mb-4 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->security->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <h3 class="mb-2 text-base font-medium text-slate-900 dark:text-slate-100 sm:text-lg">Change Password</h3>
        <form method="POST" action="{{ route('user.security.change-password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200" for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-emerald-400 dark:focus:ring-emerald-500/20 sm:px-4 sm:py-3">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200" for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-emerald-400 dark:focus:ring-emerald-500/20 sm:px-4 sm:py-3">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200" for="new_password_confirmation">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-emerald-400 dark:focus:ring-emerald-500/20 sm:px-4 sm:py-3">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <div>
        <h3 class="mb-2 text-base font-medium text-slate-900 dark:text-slate-100 sm:text-lg">Two-Factor Authentication</h3>
        @if(auth()->user()->two_factor_enabled)
            <p class="mb-2 text-sm text-emerald-600 dark:text-emerald-400">2FA is enabled on your account.</p>
            <form method="POST" action="{{ route('user.security.disable-2fa') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
                    Disable 2FA
                </button>
            </form>
        @else
            <p class="mb-2 text-sm text-amber-600 dark:text-amber-400">2FA is not enabled.</p>
            <form method="POST" action="{{ route('user.security.enable-2fa') }}">
                @csrf
                <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
                    Enable 2FA
                </button>
            </form>
        @endif
    </div>
</div>
