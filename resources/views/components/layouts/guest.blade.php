<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false, showDesktopTopbar: true, lastScroll: 0 }"
      @scroll.window="let current = window.scrollY; showDesktopTopbar = current < lastScroll || current < 10; lastScroll = current;"
      class="h-full bg-gray-100 dark:bg-gray-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bullsbybit</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Styles for the desktop topbar's scroll-hide effect */
        .desktop-topbar {
            top: 0;
            position: fixed;
            width: 100%;
            transition: top 0.3s ease;
            z-index: 30; /* Ensure it's above other content */
        }
        .desktop-topbar.-top-20 {
            top: -5rem; /* Adjust this value if your header height changes */
        }
        /* Mobile topbar will be static at the top and always visible */
        .mobile-topbar {
            position: sticky; /* or fixed, depending on desired behavior */
            top: 0;
            z-index: 30;
            width: 100%;
        }
    </style>

    @livewireStyles

</head>
<body class="h-full text-gray-800 dark:text-gray-100">

<div class="flex flex-col h-screen" x-data>

    {{-- Re-named showTopbar to showDesktopTopbar for clarity --}}
    <header :class="{'-top-20': !showDesktopTopbar, 'top-0': showDesktopTopbar}"
            class="desktop-topbar bg-white dark:bg-gray-800 shadow md:block hidden">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/">
                <!-- Light mode logo -->
                <img src="/images/logo-light.png" alt="Logo" class="w-auto h-10 dark:hidden">
                <!-- Dark mode logo -->
                <img src="/images/logo-dark.png" alt="Logo" class="bg-gray-700 w-auto h-10 hidden dark:block">
            </a>

            {{-- toolsOpen state moved inside the specific div for the dropdown --}}
            <nav class="flex space-x-6 text-sm font-medium text-gray-700 dark:text-gray-300">
                <a href="{{ url('/') }}" class="hover:underline flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l7 7m-1.5-1.5V21a1 1 0 01-1 1H10a1 1 0 01-1-1v-4a1 1 0 00-1-1H4a1 1 0 00-1 1v4a1 1 0 01-1 1H3a1 1 0 01-1-1V9l8-8 8 8z"></path></svg>
                    <span>Home</span>
                </a>
                <!--<a href="{{ route('leaderboard.public') }}" class="hover:underline flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    <span>Leaders</span>
                </a>-->

                <div class="relative" x-data="{ toolsOpen: false }">
                    <button @click="toolsOpen = !toolsOpen" class="hover:underline focus:outline-none flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Tools</span>
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

                <a href="{{ url('/about') }}" class="hover:underline flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>About</span>
                </a>
                <a href="{{ url('/help-center') }}" class="hover:underline flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9.247a8.672 8.672 0 00-1.042 3.655l-.01.002-.007.003-.004.003.004.002a7.124 7.124 0 003.366 4.965l.597.347c.602.35.937 1.007.937 1.748V20a2 2 0 01-2 2H6a2 2 0 01-2-2v-2a6 6 0 016-6 4 4 0 00-4-4v-4a4 4 0 014-4h4a4 4 0 014 4v4a4 4 0 00-4 4 6 6 0 016 6v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-1.782A7.124 7.124 0 0015.608 13.91l.004-.002.007-.003.01-.002a8.672 8.672 0 00-1.042-3.655 4 4 0 00-2.338-2.338 4 4 0 00-3.655-1.042z"></path></svg>
                    <span>Help Center</span>
                </a>
            </nav>


            <div class="flex items-center space-x-4">
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

                <a href="{{ route('login') }}" class="text-sm font-medium hover:underline flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    <span>Login</span>
                </a>
                <a href="{{ route('register') }}" class="text-sm font-medium hover:underline flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14c-1.49 0-2.43 1.25-3 2h6c-.57-.75-1.51-2-3-2z"></path></svg>
                    <span>Register</span>
                </a>
            </div>
        </div>
    </header>


    {{-- Removed the hamburger menu and its logic --}}
    <div class="mobile-topbar bg-white dark:bg-gray-800 shadow px-3 py-2 flex justify-between items-center md:hidden">
        <a href="/">
            <!-- Light mode logo -->
            <img src="/images/logo-light.png" alt="Logo" class="w-auto h-9 dark:hidden">
            <!-- Dark mode logo -->
            <img src="/images/logo-dark.png" alt="Logo" class="bg-gray-700 w-auto h-9 hidden dark:block">
        </a>

        <div class="flex items-center space-x-4">
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
            <a href="{{ route('login') }}" class="text-sm font-medium hover:underline flex items-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                <span>Login</span>
            </a>
            <a href="{{ route('register') }}" class="text-sm font-medium hover:underline flex items-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14c-1.49 0-2.43 1.25-3 2h6c-.57-.75-1.51-2-3-2z"></path></svg>
                <span>Register</span>
            </a>
        </div>
    </div>

    {{-- Adjust pt for mobile: pt-16 (based on typical mobile topbar height) vs desktop pt-20/24 --}}
    <main class="flex-1 overflow-y-auto pt-5 md:pt-20 lg:pt-24 bg-gray-100 dark:bg-gray-900">
        @if (isset($slot))
        {{ $slot }}
        @else
            {{ $content }}
        @endif
        <x-layouts.footer-guest />
    </main>
</div>


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

        
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@livewireScripts



</body>



</html>

    <!-- Mobile Sidebar -->
    <!--<aside x-show="sidebarOpen"
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
            <a href="{{ url('/') }}">Bullsbybit</a>
        </div>

        <nav class="space-y-2" x-data="{ toolsOpen: false }">
            <a href="{{ url('/') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Home</a>
            <a href="{{ route('leaderboard.public') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Leaders</a>-->
            
            <!-- Tools Dropdown Trigger -->
           <!-- <button @click="toolsOpen = !toolsOpen"
                    class="w-full text-left px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none">
                Tools
            </button>

            <!-- Tools Dropdown Menu -->
            <!--<div x-show="toolsOpen" x-transition class="pl-4">
                <div class="grid grid-cols-2 gap-1 text-sm mt-2 text-gray-700 dark:text-gray-200">
                    <a href="{{ url('/tools?section=economic-calendar') }}" class="block px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Economic Calendar</a>
                    <a href="{{ url('/tools?section=market-news') }}" class="block px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Market News</a>
                    <a href="{{ url('/tools?section=trading-signals') }}" class="block px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Trading Signals</a>
                    <a href="{{ url('/tools?section=pip-calculator') }}" class="block px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Pip Calculator</a>
                    <a href="{{ url('/tools?section=copy-guide') }}" class="block px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Copy Guide</a>
                    <a href="{{ url('/tools?section=trading-hours') }}" class="block px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Trading Hours</a>
                    <a href="{{ url('/tools?section=risk-tips') }}" class="block px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Risk Tips</a>
                    <a href="{{ url('/tools?section=currency-converter') }}" class="block px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Currency Converter</a>
                    <a href="{{ url('/tools?section=margin-calculator') }}" class="block px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Margin Calculator</a>
                    {{-- <a href="{{ url('/tools?section=live-charts') }}" class="block px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Live Charts</a> --}}
                </div>
            </div>

            <a href="{{ url('/about') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">About</a>
            <a href="{{ url('/help-center') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Help Center</a>
            <a href="{{ route('login') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Login</a>
            <a href="{{ route('register') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Register</a>
        </nav>
    </aside>-->

    <!-- Topbar (mobile only) -->
   <!-- <div class="md:hidden bg-white dark:bg-gray-800 shadow px-4 py-3 flex justify-between items-center">
        <div class="flex items-center">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 dark:text-gray-300 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <span class="ml-2 font-semibold text-lg text-gray-800 dark:text-white">Bullsbybit</span>
        </div>-->
        <!-- Mobile theme toggle -->
        <!--<button @click="$store.darkMode.toggle()" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none">
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
    </div>-->