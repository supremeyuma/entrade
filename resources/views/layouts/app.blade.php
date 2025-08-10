<!DOCTYPE html>
<html lang="en" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Entrade') }}</title>
    
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            console.log('Alpine initialized');
        });
    </script>

    <!-- Tailwind build output -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            overflow-x: hidden;
        }
        @media (max-width: 768px) {
            aside {
                z-index: 40;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 h-full min-h-screen flex flex-col">

@if(session('success'))
    <div class="bg-green-500 text-white p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

@if(session('info'))
    <div class="bg-blue-500 text-white p-3 rounded mb-4">
        {{ session('info') }}
    </div>
@endif

    
<div x-data="{ sidebarOpen: true }" class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <x-topbar />
        </div>
    </header>

    {{-- Main wrapper: sidebar + content --}}
    <div class="flex flex-1 max-w-7xl mx-auto w-full px-4 py-8 space-x-4">
        {{-- Sidebar --}}
        @auth
            <x-sidebar />
        @endauth

        {{-- Main content area --}}.trix-content {
            min-height: 100px;
        }
        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</div>

@stack('scripts')

</body>
</html>