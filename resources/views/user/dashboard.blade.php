@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">User Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }}! This is your dashboard.</p>

        <div class="mt-6">
            <p class="text-gray-600">From here you can manage your copy trades, view your trading history, and monitor your account performance.</p>
        </div>
    </div>
@endsection
