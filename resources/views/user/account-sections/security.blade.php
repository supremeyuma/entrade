{{-- resources/views/user/account-sections/security.blade.php --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6 space-y-6 sm:space-y-8">
    <h2 class="text-lg font-semibold sm:text-xl">Security Settings</h2>

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
        <h3 class="mb-2 text-base font-medium sm:text-lg">Change Password</h3>
        <form method="POST" action="{{ route('user.security.change-password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1" for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password"
                       class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white sm:px-4">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password"
                       class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white sm:px-4">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="new_password_confirmation">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                       class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white sm:px-4">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full rounded bg-blue-600 px-4 py-2 text-sm text-white transition hover:bg-blue-700 sm:w-auto">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Two-Factor Authentication -->
    <div>
        <h3 class="mb-2 text-base font-medium sm:text-lg">Two-Factor Authentication</h3>
        @if(auth()->user()->two_factor_enabled)
            <p class="mb-2 text-green-600">2FA is enabled on your account.</p>
            <form method="POST" action="{{ route('user.security.disable-2fa') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full rounded bg-red-600 px-4 py-2 text-sm text-white transition hover:bg-red-700 sm:w-auto">
                    Disable 2FA
                </button>
            </form>
        @else
            <p class="mb-2 text-yellow-600">2FA is not enabled.</p>
            <form method="POST" action="{{ route('user.security.enable-2fa') }}">
                @csrf
                <button type="submit" class="w-full rounded bg-green-600 px-4 py-2 text-sm text-white transition hover:bg-green-700 sm:w-auto">
                    Enable 2FA
                </button>
            </form>
        @endif
    </div>
</div>
