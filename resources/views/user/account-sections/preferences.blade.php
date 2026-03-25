<div class="space-y-4 rounded-[24px] border border-slate-200 bg-white p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:rounded-[28px] sm:p-6 sm:space-y-6">
    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100 sm:text-xl">Preferences</h2>

    @if(session('pref_success'))
        <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
            {{ session('pref_success') }}
        </div>
    @endif

    @if($errors->preferences && $errors->preferences->any())
        <div class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->preferences->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('user.preferences.update') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Preferred Language</label>
            <select name="language" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-emerald-400 dark:focus:ring-emerald-500/20 sm:px-4 sm:py-3">
                <option value="">Select language</option>
                <option value="en" {{ $settings?->language === 'en' ? 'selected' : '' }}>English</option>
                <option value="fr" {{ $settings?->language === 'fr' ? 'selected' : '' }}>French</option>
                <option value="es" {{ $settings?->language === 'es' ? 'selected' : '' }}>Spanish</option>
                <option value="de" {{ $settings?->language === 'de' ? 'selected' : '' }}>German</option>
            </select>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Preferred Timezone</label>
            <select name="timezone" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-emerald-400 dark:focus:ring-emerald-500/20 sm:px-4 sm:py-3">
                @foreach(timezone_identifiers_list() as $tz)
                    <option value="{{ $tz }}" {{ $settings?->timezone === $tz ? 'selected' : '' }}>
                        {{ $tz }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="inline-flex items-center space-x-2 text-sm text-slate-700 dark:text-slate-200">
                <input type="checkbox" name="email_notifications" value="1"
                    {{ $settings?->email_notifications ? 'checked' : '' }}
                    class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>Receive email notifications</span>
            </label>
        </div>

        <div class="space-y-2">
            <label class="inline-flex items-center space-x-2 text-sm text-slate-700 dark:text-slate-200">
                <input type="checkbox" name="notify_on_trade_activity" value="1"
                    {{ $settings?->notify_on_trade_activity ? 'checked' : '' }}
                    class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>Notify me on trade activity</span>
            </label>

            <label class="inline-flex items-center space-x-2 text-sm text-slate-700 dark:text-slate-200">
                <input type="checkbox" name="notify_on_withdrawal" value="1"
                    {{ $settings?->notify_on_withdrawal ? 'checked' : '' }}
                    class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>Notify me on withdrawals</span>
            </label>

            <label class="inline-flex items-center space-x-2 text-sm text-slate-700 dark:text-slate-200">
                <input type="checkbox" name="notify_on_referral" value="1"
                    {{ $settings?->notify_on_referral ? 'checked' : '' }}
                    class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>Notify me on referral activity</span>
            </label>
        </div>

        <div>
            <button type="submit"
                class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
                Save Preferences
            </button>
        </div>
    </form>
</div>
