@extends('layouts.guest')

@section('content')
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-4xl font-bold mb-4">Welcome to Entrade</h1>
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">
            Copy the best traders. Earn with the pros. Fully transparent performance. No hidden fees.
        </p>
        <a href="{{ route('register') }}"
           class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
            Get Started
        </a>
    </div>
@endsection
