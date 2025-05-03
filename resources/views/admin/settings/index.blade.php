<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <label for="deposits_enabled">Enable Deposits:</label>
    <select name="deposits_enabled" id="deposits_enabled">
        <option value="1" {{ $depositsEnabled == '1' ? 'selected' : '' }}>Enabled</option>
        <option value="0" {{ $depositsEnabled == '0' ? 'selected' : '' }}>Disabled</option>
    </select>
    <button type="submit">Save</button>
</form>
