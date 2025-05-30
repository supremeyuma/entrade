<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <x-slot name="title', 'Dashboard"></x-slot></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <nav class="mb-6">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a> |
            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">Manage User Roles</a>
            <a href="{{ route('admin.profile.edit') }}" class="text-gray-900 hover:text-gray-700">Profile</a>
        </nav>

        {{ $slot }}
    </div>
</body>
</html>