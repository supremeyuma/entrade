<x-layouts/admin>
<div class="mx-auto max-w-2xl px-4 py-6">
<h1 class="mb-4 text-xl font-bold sm:text-2xl">Edit Role for {{ $user->name }}</h1>

    <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="rounded bg-white p-4 shadow sm:p-6">
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

        <button type="submit" class="w-full rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700 sm:w-auto">Update Role</button>
    </form>
</div>
</x-layouts/admin>
