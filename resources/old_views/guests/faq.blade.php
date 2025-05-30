@extends('layouts.guest')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">Frequently Asked Questions</h1>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">How does copy trading work?</h2>
            <p class="text-gray-700 dark:text-gray-300">
                You choose a trader from the leaderboard and your account will mirror their trades automatically.
            </p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Is my money safe?</h2>
            <p class="text-gray-700 dark:text-gray-300">
                All funds are secured and only used to copy trades of the selected trader. You can withdraw at any time.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-2">What are the fees?</h2>
            <p class="text-gray-700 dark:text-gray-300">
                There are no upfront fees. Traders earn a performance-based commission only when you profit.
            </p>
        </div>
    </div>
@endsection
