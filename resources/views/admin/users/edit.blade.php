<x-layouts.admin>
    <div class="px-4 py-6 max-w-3xl">
        <h1 class="text-2xl font-bold mb-6">Edit User</h1>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white dark:bg-gray-800 p-6 rounded shadow space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full rounded border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full rounded border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Role</label>
                <select name="role" class="w-full rounded border-gray-300">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    <option value="trader" {{ $user->role === 'trader' ? 'selected' : '' }}>Trader</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <input type="text" name="status" value="{{ old('status', $user->status) }}"
                       class="w-full rounded border-gray-300" placeholder="e.g., active, suspended">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.users.show', $user) }}"
                   class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-100 mr-4">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
