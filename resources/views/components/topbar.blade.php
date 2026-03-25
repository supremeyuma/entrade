<div class="w-full bg-white dark:bg-gray-900 border-b dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left side: App name -->
            <a href="/">
                <!-- Light mode logo -->
                <img src="/images/logo-light.png" alt="Logo" class="w-auto h-10 dark:hidden">
                <!-- Dark mode logo -->
                <img src="/images/logo-dark.png" alt="Logo" class="bg-gray-700 w-auto h-10 hidden dark:block">
            </a>

            <!-- Right side: Theme toggle & profile dropdown -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <form action="{{ route('toggle.theme') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white">
                        <!-- Moon icon (shown in light mode) -->
                        <svg x-show="!document.documentElement.classList.contains('dark')" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        
                        <!-- Sun icon (shown in dark mode) -->
                        <svg x-show="document.documentElement.classList.contains('dark')" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-13.66l-.71.71M4.05 19.95l-.71-.71m16.97.71l-.71-.71M4.05 4.05l-.71.71M21 12h1M2 12H1m16.66 4.95a9 9 0 11-9.9-15.9 7 7 0 109.9 15.9z" />
                        </svg>
                    </button>
                </form>


                <!-- Profile Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center focus:outline-none">
                        <img class="h-8 w-8 rounded-full border dark:border-gray-600" src="{{ Auth::user()->profile_photo_url }}" alt="Profile Photo">
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-md shadow-lg py-1 z-50">

                        @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.profile.edit') }}"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Profile
                        </a>
                        @else
                        <a href="{{ route('user.profile.update') }}"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Profile
                        </a>
                        @endif

                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.settings.index') }}"
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Account Settings
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}"
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Account Settings
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
