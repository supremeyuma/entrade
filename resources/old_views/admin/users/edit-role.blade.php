@extends('layouts.admin')

@section('content')
    <h1 class="text-xl font-bold mb-4">Edit Role for {{ $user->name }}</h1>

    <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
        @csrf

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Select Role</label>
            <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @foreach($roles as $id => $role)
                    <option value="{{ $id }}" {{ $user->roles->first()?->id == $id ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Role</button>
    </form>
@endsection
