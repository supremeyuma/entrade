<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white border-b shadow-sm px-4 py-3 flex justify-between items-center">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold text-gray-800">Admin Dashboard</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.traders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Traders</a>
                <a href="{{ route('admin.trade_logs.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Trade Logs</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Logout</button>
                </form>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1 container mx-auto py-6 px-4">
            @yield('content')
        </main>
    </div>

</body>
</html>
