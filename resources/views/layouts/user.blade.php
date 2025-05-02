<!-- resources/views/layouts/user.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        @include('user.partials.navbar')
        <main class="mt-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
