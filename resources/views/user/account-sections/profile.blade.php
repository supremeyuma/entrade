{{-- resources/views/user/account-sections/profile.blade.php --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6">
    <h2 class="mb-4 text-lg font-semibold sm:text-xl">Profile Information</h2>

    {{-- Flash + Error Messages --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 dark:bg-green-700 dark:text-white px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 bg-red-100 text-red-800 dark:bg-red-700 dark:text-white px-4 py-3 rounded">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium mb-1">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                   class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white sm:px-4">
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium mb-1">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                   class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white sm:px-4" disabled>
            <p class="text-xs text-gray-500 mt-1">Email can't be changed. Contact support for changes.</p>
        </div>

        <!-- Phone -->
        <div>
            <label for="phone_number" class="block text-sm font-medium mb-1">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}"
                   class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white sm:px-4">
        </div>

        <!-- Country -->
        <div>
            <label for="country" class="block text-sm font-medium mb-1">Country</label>
            <input type="text" id="country" name="country" value="{{ old('country', auth()->user()->country) }}"
                   class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white sm:px-4">
        </div>

        <!-- DOB -->
        <div>
            <label for="dob" class="block text-sm font-medium mb-1">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="{{ old('dob', auth()->user()->dob) }}"
                   class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white sm:px-4">
        </div>

        <div class="pt-2 sm:pt-4">
            <button type="submit"
                    class="w-full rounded bg-blue-600 px-4 py-2 text-sm text-white transition hover:bg-blue-700 sm:w-auto">
                Save Changes
            </button>
        </div>
    </form>
</div>
