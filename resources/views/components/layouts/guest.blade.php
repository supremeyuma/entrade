<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false, showTopbar: true, lastScroll: 0 }"
      @scroll.window="let current = window.scrollY; showTopbar = current < lastScroll || current < 10; lastScroll = current;"
      class="h-full bg-gray-100 dark:bg-gray-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrade</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        header {
            top: 0;
            position: fixed;
            width: 100%;
            transition: top 0.3s ease;
        }
        .-top-20 {
            top: -5rem;
        }
    </style>
</head>
<body class="h-full text-gray-800 dark:text-gray-100">

<div class="flex flex-col h-screen" x-data>
    <!-- Mobile Sidebar -->
    <aside x-show="sidebarOpen"
           @click.away="sidebarOpen = false"
           class="fixed inset-0 z-40 bg-white dark:bg-gray-800 w-64 p-4 shadow-lg md:hidden transform transition-transform duration-300 ease-in-out"
           x-transition:enter="transform transition ease-in-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transform transition ease-in-out duration-300"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           x-cloak>
        <div class="text-lg font-semibold text-gray-700 dark:text-white border-b border-gray-200 dark:border-gray-700 mb-4">
            <a href="{{ url('/') }}">Entrade</a>
        </div>
        <nav class="space-y-2">
            <a href="{{ url('/') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Home</a>
            <a href="{{ route('leaderboard.public') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Leaders</a>
            <a href="{{ url('/about') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">About</a>
            <a href="{{ url('/faq') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Help Center</a>
            <a href="{{ route('login') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Login</a>
            <a href="{{ route('register') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Register</a>
        </nav>
    </aside>

    <!-- Topbar (desktop) -->
    <!-- Topbar (desktop) -->
<header :class="{'-top-20': !showTopbar, 'top-0': showTopbar}"
        class="z-30 bg-white dark:bg-gray-800 shadow transition-all duration-300 md:block hidden">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-800 dark:text-white">Entrade</a>

        <!-- Navigation Links -->
        <!-- Navigation Links -->
    <nav class="flex space-x-6 text-sm font-medium text-gray-700 dark:text-gray-300 relative" x-data="{ toolsOpen: false }">
        <a href="{{ url('/') }}" class="hover:underline">Home</a>
        <a href="{{ route('leaderboard.public') }}" class="hover:underline">Leaders</a>

        <!-- Tools Dropdown -->
        <div class="relative" x-data="{ toolsOpen: false }">
            <button @click="toolsOpen = !toolsOpen" class="hover:underline focus:outline-none">
                Tools
            </button>

            <div
                x-show="toolsOpen"
                x-transition
                @click.away="toolsOpen = false"
                class="absolute z-50 mt-2 w-96 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5"
            >
                <div class="py-4 px-4 grid grid-cols-2 gap-2 text-sm text-gray-700 dark:text-gray-200">
                    <a href="{{ url('/tools?section=economic-calendar') }}" class="block px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Economic Calendar</a>
                    <a href="{{ url('/tools?section=market-news') }}" class="block px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Market News</a>
                    <a href="{{ url('/tools?section=trading-signals') }}" class="block px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Trading Signals</a>
                    <a href="{{ url('/tools?section=pip-calculator') }}" class="block px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Pip Calculator</a>
                    <a href="{{ url('/tools?section=copy-guide') }}" class="block px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Copy Guide</a>
                    <a href="{{ url('/tools?section=trading-hours') }}" class="block px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Trading Hours</a>
                    <a href="{{ url('/tools?section=risk-tips') }}" class="block px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Risk Tips</a>
                    <a href="{{ url('/tools?section=currency-converter') }}" class="block px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Currency Converter</a>
                    <a href="{{ url('/tools?section=margin-calculator') }}" class="block px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Margin Calculator</a>
                    <a href="{{ url('/tools?section=live-charts') }}" class="block px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Live Charts</a>
                </div>
            </div>
        </div>



        <a href="{{ url('/about') }}" class="hover:underline">About</a>
        <a href="{{ url('/faq') }}" class="hover:underline">Help Center</a>
    </nav>


        <!-- Right Side Actions -->
        <div class="flex items-center space-x-4">
            <!-- Theme Toggle -->
            <button @click="$store.darkMode.toggle()" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none">
                <!-- Light Mode Icon -->
                <svg x-show="!$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 3v1m0 16v1m8.66-13.66l-.71.71M4.05 19.95l-.71-.71m16.97.71l-.71-.71M4.05 4.05l-.71.71M21 12h1M2 12H1m16.66 4.95a9 9 0 11-9.9-15.9 7 7 0 109.9 15.9z"/>
                </svg>
                <!-- Dark Mode Icon -->
                <svg x-show="$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

            <!-- Auth Links -->
            <a href="{{ route('login') }}" class="text-sm font-medium hover:underline">Login</a>
            <a href="{{ route('register') }}" class="text-sm font-medium hover:underline">Register</a>
        </div>
    </div>
</header>


    <!-- Topbar (mobile only) -->
    <div class="md:hidden bg-white dark:bg-gray-800 shadow px-4 py-3 flex justify-between items-center">
        <div class="flex items-center">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 dark:text-gray-300 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <span class="ml-2 font-semibold text-lg text-gray-800 dark:text-white">Entrade</span>
        </div>
        <!-- Mobile theme toggle -->
        <button @click="$store.darkMode.toggle()" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none">
            <svg x-show="!$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 3v1m0 16v1m8.66-13.66l-.71.71M4.05 19.95l-.71-.71m16.97.71l-.71-.71M4.05 4.05l-.71.71M21 12h1M2 12H1m16.66 4.95a9 9 0 11-9.9-15.9 7 7 0 109.9 15.9z"/>
            </svg>
            <svg x-show="$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>
    </div>

    <!-- Page Content -->
    <main class="flex-1 overflow-y-auto pt-20 md:pt-24 p-6 bg-gray-100 dark:bg-gray-900">
        @if (isset($slot))
        {{ $slot }}
        @else
            {{ $content }}
        @endif
        <x-components/footer/guest-footer />
    </main>
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

        if (Alpine.store('darkMode').on) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
</script>

</body>
</html>