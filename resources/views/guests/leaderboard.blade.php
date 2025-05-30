<x-layouts/guest>
<x-slot name="title', 'Trader Leaderboard">
@section('content')
<h1 class="text-3xl font-bold mb-6">Top Traders Leaderboard</h1>

@if($traders->isEmpty())
  <p class="text-gray-600 dark:text-gray-400">No traders available yet.</p>
@else
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg shadow-md">
      <thead>
        <tr class="bg-indigo-600 text-white">
          <th class="px-6 py-3 text-left">Rank</th>
          <th class="px-6 py-3 text-left">Trader</th>
          <th class="px-6 py-3 text-left">Followers</th>
          <th class="px-6 py-3 text-left">Return %</th>
          <th class="px-6 py-3 text-left">Profile</th>
        </tr>
      </thead>
      <tbody>
        @foreach($traders as $index => $trader)
          <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-3">{{ $index + 1 }}</td>
            <td class="px-6 py-3 font-semibold">{{ $trader->name }}</td>
            <td class="px-6 py-3">{{ $trader->subscribers_count }}</td>
            <td class="px-6 py-3">{{ number_format($trader->average_return_percent, 2) }}%</td>
            <td class="px-6 py-3">
              <a href="{{ route('guests.trader-profile', $trader->id) }}" class="text-indigo-600 hover:underline">View</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endif
</x-slot>
</x-layouts/guest>
