<x-layouts/admin>
<div class="mx-auto max-w-3xl px-4 py-6">
    <h2 class="mb-4 text-xl font-semibold sm:text-2xl">Theme Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.theme.settings.update') }}" class="rounded bg-white p-4 shadow sm:p-6">
        @csrf

        <div class="form-group">
            <label for="theme_default">Default Theme</label>
            <select class="form-control" name="theme_default" id="theme_default">
                <option value="light" {{ $defaultTheme === 'light' ? 'selected' : '' }}>Light</option>
                <option value="dark" {{ $defaultTheme === 'dark' ? 'selected' : '' }}>Dark</option>
                <option value="system" {{ $defaultTheme === 'system' ? 'selected' : '' }}>System Default</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="allow_override">Allow Users to Choose Their Own Theme?</label>
            <select class="form-control" name="allow_override" id="allow_override">
                <option value="1" {{ $allowOverride === 'true' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ $allowOverride === 'false' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button class="mt-3 w-full rounded bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700 sm:w-auto" type="submit">Save Settings</button>
    </form>
</div>
</x-layouts/admin>
