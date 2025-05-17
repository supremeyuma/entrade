@extends('layouts.guest')

@section('title', 'Trader Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <header class="flex items-center space-x-4">
    <div class="bg-indigo-500 rounded-full h-20 w-20 flex items-center justify-center text-white text-3xl font-bold">
      {{ strtoupper(substr($trader->name, 0, 2)) }}
    </div>
    <div>
      <h1 class="text-2xl font-bold">{{ $trader->name }}</h1>
      <p class="text-gray-600 dark:text-gray-400">{{ $trader->bio ?? 'No bio available.' }}</p>
      <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
        Followers: {{ $trader->subscribers_count }} | Average Return: {{ number_format($trader->average_return_percent, 2) }}%
      </div>
    </div>
  </header>

  <section>
    <h2 class="text-xl font-semibold mb-3">Recent Trades</h2>
    @if($recentTrades->isEmpty())
      <p class="text-gray-600 dark:text-gray-400">No trades to display.</p>
    @else
      <ul class="space-y-2">
        @foreach($recentTrades as $trade)
          <li class="p-4 bg-white dark:bg-gray-700 rounded shadow hover:bg-indigo-50 dark:hover:bg-indigo-800 transition">
            <div class="flex justify-between">
              <span class="font-semibold">{{ $trade->pair }}</span>
              <span class="text-sm {{ $trade->outcome == 'win' ? 'text-green-600' : ($trade->outcome == 'loss' ? 'text-red-600' : 'text-gray-500') }}">
                {{ ucfirst($trade->outcome) ?? 'N/A' }}
              </span>
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-300">{{ $trade->created_at->format('M d, Y') }}</div>
          </li>
        @endforeach
      </ul>
    @endif
  </section>

  <section class="pt-6 border-t border-gray-300 dark:border-gray-600">
    <a href="{{ route('guests.trader-trades', $trader->id) }}" 
       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
      View All Trades
    </a>
  </section>

</div>
@endsection
