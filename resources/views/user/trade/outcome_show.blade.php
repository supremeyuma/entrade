<x-layouts.app>
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">📊 Trade Outcome Details</h1>

    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-indigo-600 mb-4">👤 Trader Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div><span class="font-medium">Name:</span> {{ $trader->name }}</div>
            <div><span class="font-medium">Trader ID:</span> {{ $trader->trader_id }}</div>
            <div><span class="font-medium">Cumulative ROI:</span> {{ number_format($cumulativeRoi, 2) }}%</div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-indigo-600 mb-4">📈 Outcome Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div><span class="font-medium">Percentage Change:</span> {{ $percentageChange }}%</div>
            <div><span class="font-medium">Recorded At:</span> {{ $lastHistory->created_at->format('M d, Y h:i A') }}</div>
        </div>
    </div>

    @if($userSubscription)
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-indigo-600 mb-4">📌 Your Subscription Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div><span class="font-medium">Allocated Amount:</span> ${{ number_format($userSubscription->allocated_amount, 2) }}</div>
            <div><span class="font-medium">Subscribed Since:</span> {{ $userSubscription->created_at->diffForHumans() }} ({{ $daysSubscribed }} days)</div>
            <div><span class="font-medium">Gain/Loss:</span> 
                <span class="{{ $gainLoss >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $gainLoss >= 0 ? '+' : '' }}${{ number_format($gainLoss, 2) }}
                </span>
            </div>
            <div><span class="font-medium">Updated Allocation:</span> ${{ number_format($newBalance, 2) }}</div>
        </div>
    </div>
    @else
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 rounded px-4 py-3 mb-6">
        ⚠️ You are not currently subscribed to this trader.
    </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-indigo-600 mb-4">📅 Last 3 Trade Outcomes</h2>

        @if($recentOutcomes->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700 border border-gray-200 rounded-md overflow-hidden">
                <thead class="bg-gray-100 text-xs uppercase font-medium text-gray-600">
                    <tr>
                        <th class="px-4 py-3 border">Date</th>
                        <th class="px-4 py-3 border">ROI</th>
                        <th class="px-4 py-3 border">Profit/Loss</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOutcomes as $outcome)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $outcome->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2 border">{{ $outcome->roi }}%</td>
                        <td class="px-4 py-2 border">
                            ${{ number_format($outcome->amount_returned - $outcome->amount_invested, 2) ?? '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-gray-600">No recent trade outcomes found.</p>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('user.tradingDashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700 transition">
            ← Back to Trade Dashboard
        </a>
    </div>
</div>
</x-layouts.app>
