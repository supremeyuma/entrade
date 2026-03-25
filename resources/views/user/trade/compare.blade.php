<x-layouts.app>
<div class="container mx-auto max-w-6xl px-4 py-6">
    <h1 class="mb-4 text-2xl font-bold sm:mb-6 sm:text-3xl">Trader Comparison</h1>

    @if($traders->isEmpty())
        <p>No traders selected for comparison.</p>
        <a href="{{ route('user.leaderboard') }}" class="btn btn-primary mt-4">Back to Leaderboard</a>
    @else
        <div class="overflow-x-auto">
            <table class="table w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-3 py-2">Metric</th>
                        @foreach($traders as $trader)
                            <th class="border border-gray-300 px-3 py-2 text-center">{{ $trader->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-semibold">ROI (%)</td>
                        @foreach($traders as $trader)
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ number_format($trader->roi, 2) }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-semibold">Win Rate (%)</td>
                        @foreach($traders as $trader)
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ number_format($trader->win_rate, 2) }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-semibold">Subscribers</td>
                        @foreach($traders as $trader)
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ $trader->subscriptions_count }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-semibold">Total Trades</td>
                        @foreach($traders as $trader)
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ $trader->trades_count }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="{{ route('user.leaderboard') }}" class="btn btn-secondary mt-6">Back to Leaderboard</a>
    @endif
</div>
</x-layouts.app>
