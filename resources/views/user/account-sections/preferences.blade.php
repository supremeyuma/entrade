<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6 space-y-4 sm:space-y-6">
    <h2 class="text-lg font-semibold sm:text-xl">Preferences</h2>

    {{-- Flash + Error Messages --}}
    @if(session('pref_success'))
        <div class="bg-green-100 text-green-800 dark:bg-green-700 dark:text-white px-4 py-3 rounded">
            {{ session('pref_success') }}
        </div>
    @endif

    @if($errors->preferences && $errors->preferences->any())
        <div class="bg-red-100 text-red-800 dark:bg-red-700 dark:text-white px-4 py-3 rounded">
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

        {{-- Language --}}
        <div>
            <label class="block text-sm font-medium mb-1">Preferred Language</label>
            <select name="language" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white sm:px-4">
                <option value="">Select language</option>
                <option value="en" {{ $settings?->language === 'en' ? 'selected' : '' }}>English</option>
                <option value="fr" {{ $settings?->language === 'fr' ? 'selected' : '' }}>French</option>
                <option value="es" {{ $settings?->language === 'es' ? 'selected' : '' }}>Spanish</option>
                <option value="de" {{ $settings?->language === 'de' ? 'selected' : '' }}>German</option>
            </select>
        </div>

        {{-- Timezone --}}
        <div>
            <label class="block text-sm font-medium mb-1">Preferred Timezone</label>
            <select name="timezone" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white sm:px-4">
                @foreach(timezone_identifiers_list() as $tz)
                    <option value="{{ $tz }}" {{ $settings?->timezone === $tz ? 'selected' : '' }}>
                        {{ $tz }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Notifications --}}
        <div>
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="email_notifications" value="1"
                       {{ $settings?->email_notifications ? 'checked' : '' }}
                       class="form-checkbox h-5 w-5 text-blue-600">
                <span>Receive email notifications</span>
            </label>
        </div>

        {{-- Additional Notification Toggles --}}
        <div class="space-y-2">
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="notify_on_trade_activity" value="1"
                    {{ $settings?->notify_on_trade_activity ? 'checked' : '' }}
                    class="form-checkbox h-5 w-5 text-blue-600">
                <span>Notify me on trade activity</span>
            </label>

            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="notify_on_withdrawal" value="1"
                    {{ $settings?->notify_on_withdrawal ? 'checked' : '' }}
                    class="form-checkbox h-5 w-5 text-blue-600">
                <span>Notify me on withdrawals</span>
            </label>

            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="notify_on_referral" value="1"
                    {{ $settings?->notify_on_referral ? 'checked' : '' }}
                    class="form-checkbox h-5 w-5 text-blue-600">
                <span>Notify me on referral activity</span>
            </label>
        </div>



        <div>
            <button type="submit"
                    class="w-full rounded bg-blue-600 px-4 py-2 text-sm text-white transition hover:bg-blue-700 sm:w-auto">
                Save Preferences
            </button>
        </div>
    </form>
</div>
