<x-layouts/admin>
<div class="container">
    <h2>Theme Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.theme.settings.update') }}">
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

        <button class="btn btn-primary mt-3" type="submit">Save Settings</button>
    </form>
</div>
</x-layouts/admin>
