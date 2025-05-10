@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Welcome to Your Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Account Summary -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">Account Summary</h2>
            <p>Balance: $0.00</p>
            <p>Country: {{ Auth::user()->country ?? 'N/A' }}</p>
            <p>Phone: {{ Auth::user()->phone_number ?? 'N/A' }}</p>
        </div>

        <!-- Copy Trading Section -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">Your Copy Trading</h2>
            <p>You are currently not copying any trader.</p>
        </div>

        <!-- Latest Trades (Stub) -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">Latest Trades</h2>
            <p>No trades yet.</p>
        </div>

        <!--Referral Stats-->
        <div class="bg-white shadow rounded-lg p-4">
            <h3>Referral Stats</h3>
            <ul>
                <li>Total referrals: {{ auth()->user()->referralCount() }}</li>
                {{-- <li>Total bonus earned: {{ auth()->user()->referralBonusTotal() }}</li> --}}
            </ul>
            <a href="{{ route('user.referrals.index') }}">View my referrals</a>
        </div>
    </div>
</div>
@endsection
