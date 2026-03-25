<x-layouts.app>
<div class="max-w-5xl mx-auto px-4 py-6 sm:py-8">
    <h1 class="mb-4 text-xl font-semibold text-gray-800 sm:mb-6 sm:text-2xl">Trade Outcome Details</h1>

    <div class="mb-6 rounded-lg bg-white p-4 shadow sm:mb-8 sm:p-6">
        <h2 class="mb-4 text-base font-semibold text-indigo-600 sm:text-lg">Trader Information</h2>
        <div class="grid grid-cols-1 gap-4 text-sm text-gray-700 md:grid-cols-2">
            <div><span class="font-medium">Name:</span> {{ $trader->name }}</div>
            <div><span class="font-medium">Trader ID:</span> {{ $trader->trader_id }}</div>
            <div><span class="font-medium">Cumulative ROI:</span> {{ number_format($cumulativeRoi, 2) }}%</div>
        </div>
    </div>

    <div class="mb-6 rounded-lg bg-white p-4 shadow sm:mb-8 sm:p-6">
        <h2 class="mb-4 text-base font-semibold text-indigo-600 sm:text-lg">Outcome Information</h2>
        <div class="grid grid-cols-1 gap-4 text-sm text-gray-700 md:grid-cols-2">
            <div><span class="font-medium">Percentage Change:</span> {{ $percentageChange }}%</div>
            <div><span class="font-medium">Recorded At:</span> {{ $lastHistory->created_at->format('M d, Y h:i A') }}</div>
        </div>
    </div>

    @if($userSubscription)
    <div class="mb-6 rounded-lg bg-white p-4 shadow sm:mb-8 sm:p-6">
        <h2 class="mb-4 text-base font-semibold text-indigo-600 sm:text-lg">Your Subscription Details</h2>
        <div class="grid grid-cols-1 gap-4 text-sm text-gray-700 md:grid-cols-2">
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
    <div class="mb-6 rounded border border-yellow-400 bg-yellow-100 px-4 py-3 text-yellow-800">
        You are not currently subscribed to this trader.
    </div>
    @endif

    <div class="rounded-lg bg-white p-4 shadow sm:p-6">
        <h2 class="mb-4 text-base font-semibold text-indigo-600 sm:text-lg">Last 3 Trade Outcomes</h2>

        @if($recentOutcomes->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full overflow-hidden rounded-md border border-gray-200 text-left text-sm text-gray-700">
                <thead class="bg-gray-100 text-xs font-medium uppercase text-gray-600">
                    <tr>
                        <th class="border px-4 py-3">Date</th>
                        <th class="border px-4 py-3">ROI</th>
                        <th class="border px-4 py-3">Profit/Loss</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOutcomes as $outcome)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $outcome->created_at->format('M d, Y') }}</td>
                        <td class="border px-4 py-2">{{ $outcome->roi }}%</td>
                        <td class="border px-4 py-2">
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
        <a href="{{ route('user.tradingDashboard') }}" class="inline-flex items-center rounded bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700">
            Back to Trade Dashboard
        </a>
    </div>
</div>
</x-layouts.app>
