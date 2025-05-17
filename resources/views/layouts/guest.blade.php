<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false }" class="h-full bg-gray-100 dark:bg-gray-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrade</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="h-full text-gray-800 dark:text-gray-100">

<div class="flex h-screen" x-data="{ sidebarOpen: false }">
    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-black bg-opacity-50 md:hidden"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
    </div>

    <!-- Sidebar -->
    <aside :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
           class="fixed z-40 inset-y-0 left-0 w-64 bg-white dark:bg-gray-800 shadow-md transform transition-transform duration-200 ease-in-out md:relative md:translate-x-0 md:flex md:flex-col"
           x-cloak>
        <div class="p-4 text-lg font-semibold text-gray-700 dark:text-white border-b border-gray-200 dark:border-gray-700">
            <a href="{{ url('/') }}">Entrade</a>
        </div>
        <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-2">
            <a href="{{ url('/') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Home</a>
            <a href="{{ route('leaderboard.public') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Leaderboard</a>
            <a href="{{ url('/about') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">About</a>
            <a href="{{ url('/faq') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">FAQ</a>
            <a href="{{ route('login') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Login</a>
            <a href="{{ route('register') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Register</a>
        </nav>
    </aside>

    <!-- Main content area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="w-full bg-white dark:bg-gray-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center">
                    <!-- Sidebar toggle (mobile) -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 dark:text-gray-300 md:hidden focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <!-- Site name (mobile only) -->
                    <span class="ml-2 font-semibold text-lg text-gray-800 dark:text-white md:hidden">Entrade</span>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Theme toggle -->
                    <button @click="$store.darkMode.toggle()" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none">
                        <!-- Sun Icon (shown in light mode) -->
                        <svg x-show="!$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m8.66-13.66l-.71.71M4.05 19.95l-.71-.71m16.97.71l-.71-.71M4.05 4.05l-.71.71M21 12h1M2 12H1m16.66 4.95a9 9 0 11-9.9-15.9 7 7 0 109.9 15.9z" />
                        </svg>
                        
                        <!-- Moon Icon (shown in dark mode) -->
                        <svg x-show="$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <!-- Auth buttons (for guest only) -->
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:underline">Register</a>
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-100 dark:bg-gray-900">
            @yield('content')
        </main>
    </div>
</div>

@livewireScripts

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('darkMode', {
            on: localStorage.theme === 'dark' || 
                (!('theme' in localStorage) && 
                window.matchMedia('(prefers-color-scheme: dark)').matches),

            toggle() {
                this.on = !this.on;
                if (this.on) {
                    localStorage.theme = 'dark';
                    document.documentElement.classList.add('dark');
                } else {
                    localStorage.theme = 'light';
                    document.documentElement.classList.remove('dark');
                }
            }
        });

        // Initialize theme on page load
        if (Alpine.store('darkMode').on) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
</script>
</body>
</html>
