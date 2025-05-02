@extends('layouts.user')

@section('content')
    <h1 class="text-2xl mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 bg-white shadow rounded-xl">
            <h2 class="text-lg font-semibold">Balance</h2>
            <p class="mt-2 text-2xl font-bold">${{ number_format($balance, 2) }}</p>
        </div>

        <div class="p-4 bg-white shadow rounded-xl">
            <h2 class="text-lg font-semibold">Portfolio</h2>
            <p class="mt-2">Invested: ${{ number_format($portfolioSummary['total_invested'], 2) }}</p>
            <p>Returns: ${{ number_format($portfolioSummary['total_returns'], 2) }}</p>
            <p class="font-bold {{ $portfolioSummary['net_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                Net Profit: ${{ number_format($portfolioSummary['net_profit'], 2) }}
            </p>
        </div>

        <div class="p-4 bg-white shadow rounded-xl">
            <h2 class="text-lg font-semibold">Active Trades</h2>
            <ul class="mt-2">
                @foreach ($activeTrades as $trade)
                    <li class="mb-2">
                        <span class="font-medium">{{ $trade['trader'] }}</span> - 
                        <span class="text-sm">{{ $trade['status'] }}</span> 
                        (<span class="text-green-600">{{ $trade['profit'] }}</span>)
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
