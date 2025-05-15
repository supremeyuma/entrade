<!DOCTYPE html>
<html lang="en" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Entrade') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold">Entrade</a>
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

    <main class="max-w-7xl mx-auto py-8 px-4">
        @yield('content')
    </main>
</body>
</html>
