@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 bg-white rounded shadow">
            <h2 class="text-lg font-semibold">Total Users</h2>
            <p class="mt-2 text-3xl">{{ $totalUsers }}</p>
        </div>

        <div class="p-4 bg-white rounded shadow">
            <h2 class="text-lg font-semibold">Adminss</h2>
            <p class="mt-2 text-3xl">{{ $admins }}</p>
        </div>

        <div class="p-4 bg-white rounded shadow">
            <h2 class="text-lg font-semibold">Traders</h2>
            <p class="mt-2 text-3xl">{{ $traders }}</p>
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ route('admin.users.index') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Manage Users
        </a>
    </div>
@endsection
