<x-admin/layout>
<div class="mx-auto max-w-4xl px-4 py-6">
<h1 class="mb-4 text-xl font-semibold sm:text-2xl">Referral Settings</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.site_settings.referral.update') }}" class="rounded bg-white p-4 shadow sm:p-6">
        @csrf

        @foreach($settings as $setting)
            <div class="mb-4">
                <label>{{ ucwords(str_replace('_', ' ', $setting->key)) }} ({{ $setting->description }})</label>
                <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="form-control">
            </div>
        @endforeach

        <button type="submit" class="w-full rounded bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700 sm:w-auto">Save Settings</button>
    </form>
</div>
</x-admin/layout>
