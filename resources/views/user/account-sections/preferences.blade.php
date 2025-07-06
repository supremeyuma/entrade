<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-6">
    <h2 class="text-xl font-semibold">Preferences</h2>

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
            <select name="language" class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white">
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
            <select name="timezone" class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white">
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

        <div>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Save Preferences
            </button>
        </div>
    </form>
</div>
