@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 space-y-6">
    <h1 class="text-2xl font-bold mb-4">Welcome to Your Dashboard</h1>

    <!-- Account Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">Account Summary</h2>
            <p>Balance: <strong>${{ number_format($balance, 2) }}</strong></p>
            <p>Country: {{ $user->country ?? 'N/A' }}</p>
            <p>Phone: {{ $user->phone_number ?? 'N/A' }}</p>
        </div>

        <!-- Portfolio Summary -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">Portfolio Summary</h2>
            <p>Total Invested: <strong>${{ number_format($portfolioSummary['total_invested'], 2) }}</strong></p>
            <p>Total Returns: <strong>${{ number_format($portfolioSummary['total_returns'], 2) }}</strong></p>
            <p>Net Profit: 
                <strong class="{{ $portfolioSummary['net_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    ${{ number_format($portfolioSummary['net_profit'], 2) }}
                </strong>
            </p>
        </div>

        <!-- Referral Stats -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">Referral Stats</h2>
            <p>Total referrals: {{ $referrals->count() }}</p>
            <p>Total bonus earned: ${{ number_format($referrals->sum('bonus'), 2) }}</p>
            <a href="{{ route('user.referrals.index') }}" class="text-blue-600 hover:underline">View my referrals</a>
        </div>
    </div>

    <!-- Copy Trading Section -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-2">Your Copy Trading</h2>
        @if($activeTrades->isEmpty())
            <p>You are currently not copying any trader.</p>
        @else
            <ul class="space-y-2">
                @foreach($activeTrades as $trade)
                    <li>
                        {{ $trade->trader_name }} — 
                        <span class="{{ $trade->outcome >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trade->outcome }}%
                        </span> on {{ $trade->created_at->format('M d, Y') }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Recent Trades -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-2">Recent Trades</h2>
        @if($recentTrades->isEmpty())
            <p>No trades yet.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-left">
                        <th class="py-2">Trader</th>
                        <th class="py-2">Outcome</th>
                        <th class="py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTrades as $trade)
                        <tr class="border-b">
                            <td class="py-2">{{ $trade->trader->name }}</td>
                            <td class="py-2 {{ $trade->outcome >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $trade->outcome }}%
                            </td>
                            <td class="py-2">{{ $trade->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
