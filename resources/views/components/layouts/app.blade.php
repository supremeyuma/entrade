<!DOCTYPE html>
<html lang="en" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Official website of BullsBybit, a licensed copytrading platform."/>
    <meta name="keywords" content="BullsBybit, Trading, copytrading, passive income, financial market"/>
    <title>{{ config('app.name', 'BullsBybit') }}</title>
    <link rel="icon" type="image/png" href="/images/favicon.png">
    
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>-->

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
        <!--AOS-->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
            once: true,
            duration: 700,
            easing: 'ease-out-cubic',
            });
        });
    </script>


    <style>
        html {
            overflow-x: hidden;
            [x-cloak] { display: none !important; }
        }
    </style>


</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen">

<div x-data="{ sidebarOpen: false }" class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow w-full z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Sidebar toggle button (mobile only) -->
            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-600 dark:text-gray-200 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Topbar content -->
            <x-topbar />
        </div>
    </header>

    @if (session('success') || session('error') || session('info') || session()->has('impersonator_id'))
        <div class="w-full border-b border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-3">
                @if (session()->has('impersonator_id'))
                    <div class="flex flex-col gap-3 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-100 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            You are currently browsing as <strong>{{ auth()->user()?->name }}</strong>.
                        </div>
                        <form method="POST" action="{{ route('impersonation.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex rounded-xl bg-amber-600 px-4 py-2 font-semibold text-white transition hover:bg-amber-500">
                                Return to Admin
                            </button>
                        </form>
                    </div>
                @endif

                @if (session('success'))
                    <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="rounded-2xl bg-sky-50 px-4 py-3 text-sm text-sky-700 dark:bg-sky-500/10 dark:text-sky-300">
                        {{ session('info') }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    @auth
        <div
            x-cloak
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 z-30 bg-black/30 md:hidden"
            @click="sidebarOpen = false"
        ></div>
    @endauth

    <!-- Main wrapper: sidebar + content -->
    <div class="flex flex-1 max-w-7xl mx-auto w-full px-4 py-8 space-x-4">
        <!-- Sidebar -->
        @auth
            <aside
                class="fixed md:static inset-y-0 left-0 w-64 transform overflow-y-auto bg-white pt-20 dark:bg-gray-800 md:pt-0 md:translate-x-0 z-40 transition-transform duration-200 ease-in-out"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
                <x-sidebar />
            </aside>
        @endauth

        <!-- Main content area -->
        <main class="flex-1 md:ml-0">
            {{ $slot }}
        </main>
    </div>
</div>


</body>
</html>
