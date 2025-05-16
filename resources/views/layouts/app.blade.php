<!DOCTYPE html>
<html lang="en" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Entrade') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Script for theme change -->
    <script type="module">
        import { setTheme } from '/resources/js/theme.js';

        @if (auth()->check())
            setTheme('{{ auth()->user()->theme_preference ?? 'light' }}');
        @endif
    </script>
    <!-- End of script for theme change -->
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 h-full min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                {{-- Sidebar toggle button for small screens --}}
                @auth
                <button @click="$dispatch('toggle-sidebar')" class="md:hidden p-2 rounded text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700" aria-label="Toggle sidebar">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                @endauth

                <a href="{{ route('home') }}" class="text-xl font-bold">Entrade</a>
            </div>

            <div>
                <form action="{{ route('toggle.theme') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white">
                        {{ session('theme') === 'dark' ? 'Light Mode' : 'Dark Mode' }}
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- Main wrapper: sidebar + content --}}
    <div class="flex flex-1 max-w-7xl mx-auto w-full px-4 py-8 space-x-4">
        {{-- Sidebar --}}
        @auth
            <x-sidebar />
        @endauth

        {{-- Main content area --}}
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

</body>
</html>
