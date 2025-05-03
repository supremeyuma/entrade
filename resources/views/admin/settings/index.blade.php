@extends('layouts.admin')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Site Settings</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf

            <div class="mb-4">
                <label for="deposits_enabled" class="block text-sm font-medium text-gray-700">Enable Deposits:</label>
                <select name="deposits_enabled" id="deposits_enabled" class="mt-1 block w-full border-gray-300 rounded">
                    <option value="1" {{ $depositsEnabled == '1' ? 'selected' : '' }}>Enabled</option>
                    <option value="0" {{ $depositsEnabled == '0' ? 'selected' : '' }}>Disabled</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
        </form>
    </div>
@endsection
