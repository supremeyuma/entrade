@extends('admin.layout')

@section('content')
    <h1>Referral Settings</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.site_settings.referral.update') }}">
        @csrf

        @foreach($settings as $setting)
            <div class="mb-4">
                <label>{{ ucwords(str_replace('_', ' ', $setting->key)) }} ({{ $setting->description }})</label>
                <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="form-control">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
@endsection
