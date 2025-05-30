@extends('layouts.guest')

@section('title', 'Trader Trade History')

@section('content')
<h1 class="text-3xl font-bold mb-6">Trade History - {{ $trader->name }}</h1>

@if($trades->isEmpty())
  <p class="text-gray-600 dark:text-gray-400">No trade history available.</p>
@else
  <div class="overflow-x-auto rounded shadow bg-white dark:bg-gray-700">
    <table class="min-w-full table-auto">
      <thead>
        <tr class="bg-indigo-600 text-white">
          <th class="px-6 py-3 text-left">Date</th>
          <th class="px-6 py-3 text-left">Pair</th>
          <th class="px-6 py-3 text-left">Type</th>
          <th class="px-6 py-3 text-left">Amount</th>
          <th class="px-6 py-3 text-left">Outcome</th>
        </tr>
      </thead>
      <tbody>
        @foreach($trades as $trade)
          <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-3">{{ $trade->created_at->format('M d, Y') }}</td>
            <td class="px-6 py-3">{{ $trade->pair }}</td>
            <td class="px-6 py-3 capitalize">{{ $trade->trade_type }}</td>
            <td class="px-6 py-3">{{ $trade->amount }}</td>
            <td class="px-6 py-3 {{ $trade->outcome == 'win' ? 'text-green-600' : ($trade->outcome == 'loss' ? 'text-red-600' : 'text-gray-500') }}">
              {{ ucfirst($trade->outcome) ?? 'N/A' }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $trades->links() }}
  </div>
@endif
@endsection
