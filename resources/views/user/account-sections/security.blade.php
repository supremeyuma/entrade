{{-- resources/views/user/account-sections/security.blade.php --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-8">
    <h2 class="text-xl font-semibold">Security Settings</h2>

    {{-- Flash Messages --}}
    @if(session('security_success'))
        <div class="mb-4 bg-green-100 text-green-800 dark:bg-green-700 dark:text-white px-4 py-3 rounded">
            {{ session('security_success') }}
        </div>
    @endif

    @if($errors->security && $errors->security->any())
        <div class="mb-4 bg-red-100 text-red-800 dark:bg-red-700 dark:text-white px-4 py-3 rounded">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->security->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Change Password -->
    <div>
        <h3 class="text-lg font-medium mb-2">Change Password</h3>
        <form method="POST" action="{{ route('user.security.change-password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1" for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password"
                       class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password"
                       class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="new_password_confirmation">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                       class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white">
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Two-Factor Authentication -->
    <div>
        <h3 class="text-lg font-medium mb-2">Two-Factor Authentication</h3>
        @if(auth()->user()->two_factor_enabled)
            <p class="mb-2 text-green-600">2FA is enabled on your account.</p>
            <form method="POST" action="{{ route('user.security.disable-2fa') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Disable 2FA
                </button>
            </form>
        @else
            <p class="mb-2 text-yellow-600">2FA is not enabled.</p>
            <form method="POST" action="{{ route('user.security.enable-2fa') }}">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    Enable 2FA
                </button>
            </form>
        @endif
    </div>
</div>
