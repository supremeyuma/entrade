<!DOCTYPE html>
<html lang="en" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Entrade') }}</title>
    
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>-->

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

    <!-- Main wrapper: sidebar + content -->
    <div class="flex flex-1 max-w-7xl mx-auto w-full px-4 py-8 space-x-4">
        <!-- Sidebar -->
        @auth
            <aside
                class="fixed md:static inset-y-0 left-0 w-64 transform bg-white dark:bg-gray-800 md:translate-x-0 z-40 transition-transform duration-200 ease-in-out"
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
