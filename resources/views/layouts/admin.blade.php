@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col">
        <!-- Navbar 
        <nav class="bg-white border-b shadow-sm px-4 py-3 flex justify-between items-center">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold text-gray-800">Admion Dashboard</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.traders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Traders</a>
                <a href="{{ route('admin.trade_logs.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Trade Logs</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Logout</button>
                </form>
            </div>
        </nav>--->
S
        <!-- Page Content -->
        <main class="flex-1 md:ml-64">
            @yield('content')
        </main>
    </div>
@endsection
