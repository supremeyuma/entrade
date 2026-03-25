{{-- resources/views/user/account-sections/profile.blade.php --}}
<div class="rounded-[24px] border border-slate-200 bg-white p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:rounded-[28px] sm:p-6">
    <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-slate-100 sm:text-xl">Profile Information</h2>

    @if(session('success'))
        <div class="mb-4 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4 sm:space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-emerald-400 dark:focus:ring-emerald-500/20 sm:px-4 sm:py-3">
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-3 py-2 text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-400 sm:px-4 sm:py-3" disabled>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Email can't be changed. Contact support for changes.</p>
        </div>

        <div>
            <label for="phone_number" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-emerald-400 dark:focus:ring-emerald-500/20 sm:px-4 sm:py-3">
        </div>

        <div>
            <label for="country" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Country</label>
            <input type="text" id="country" name="country" value="{{ old('country', auth()->user()->country) }}"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-emerald-400 dark:focus:ring-emerald-500/20 sm:px-4 sm:py-3">
        </div>

        <div>
            <label for="dob" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="{{ old('dob', auth()->user()->dob) }}"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-emerald-400 dark:focus:ring-emerald-500/20 sm:px-4 sm:py-3">
        </div>

        <div class="pt-2 sm:pt-4">
            <button type="submit"
                class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
                Save Changes
            </button>
        </div>
    </form>
</div>
