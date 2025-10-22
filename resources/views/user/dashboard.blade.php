<x-layouts.app>
<div class="container mx-auto px-4 space-y-6">
    
    <h1 class="text-2xl font-bold mb-2">Welcome to Your Dashboard</h1>

    @php
        $hasDeposited = $totalInvested > 0;
        $isFollowingTraders = $user->copiedTraders()->exists();
    @endphp
    
    {{-- Show notices only when necessary --}}
    
    <div class="space-y-3 mb-6">
    
        {{-- No Deposit Yet --}}
        @if (!$hasDeposited)
            <div data-aos="fade-up" data-aos-delay="100"
                 class="flex items-start gap-3 p-4 bg-yellow-50 border border-yellow-200 rounded-xl shadow-sm">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-yellow-700 w-6 h-6">
                        <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                        <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z" clip-rule="evenodd" />
                        <path d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
                    </svg>


                </div>
                <div>
                    <p class="text-yellow-800 font-medium">
                        You haven’t made your first deposit yet.
                        <a href="{{ route('user.deposit.create') }}" class="font-semibold text-yellow-700 hover:underline">
                            Make your first deposit
                        </a>
                        to begin your journey.
                    </p>
                </div>
            </div>
        @endif
    
        {{-- Not Following Any Traders --}}
        @if (!$isFollowingTraders)
            <div data-aos="fade-up" data-aos-delay="200"
                 class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 rounded-xl shadow-sm">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-blue-800 w-6 h-6">
                      <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd" />
                      <path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                    </svg>

                </div>
                <div>
                    <p class="text-blue-800 font-medium">
                        You’re currently not following any traders.
                        <a href="{{ route('user.trade.search') }}" class="font-semibold text-blue-700 hover:underline">
                            Explore our top traders
                        </a>
                        and start copying their trades.
                    </p>
                </div>
            </div>
        @elseif ($hasDeposited)
            <div data-aos="fade-up" data-aos-delay="300"
                 class="flex items-start gap-3 p-4 bg-green-50 border border-green-200 rounded-xl shadow-sm">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-green-800 w-6 h-6">
                      <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z" />
                    </svg>

                </div>
                <div>
                    <p class="text-green-800 font-medium">
                        <a href="{{ route('user.deposit.create') }}" class="font-semibold text-green-700 hover:underline">
                            Make a new deposit
                        </a>
                        or
                        <a href="{{ route('user.trade.search') }}" class="font-semibold text-green-700 hover:underline">
                            copy more top traders
                        </a>
                        to grow your portfolio.
                    </p>
                </div>
            </div>
        @endif
    </div>



   <!-- Account / Portfolio / Referral Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div data-aos="fade-up" data-aos-delay="100" class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">Account Summary</h2>
            <p>Main Balance: <strong>${{ number_format($main_balance, 2) }}</strong></p>
            <p>Trade Balance: <strong>${{ number_format($trade_balance, 2) }}</strong></p>
            <p>Country: {{ $user->country ?? 'N/A' }}</p>
            <p>Phone: {{ $user->phone_number ?? 'N/A' }}</p>
        </div>

        <div data-aos="fade-up" data-aos-delay="200" class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">Portfolio Summary</h2>
            <p>Total Invested: <strong>${{ number_format($totalInvested, 2) }}</strong></p>
            <p>Total Returns: <strong>${{ number_format($totalReturns, 2) }}</strong></p>
            <p>Net Profit: 
                <strong class="{{ $netProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    ${{ number_format($netProfit, 2) }}
                </strong>
            </p>
            <p>Average ROI: 
                <strong class="{{ $netProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($averageRoi, 2) }}%
                </strong>
            </p>
        </div>

        <div data-aos="fade-up" data-aos-delay="300" class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">Referral Stats</h2>
            <p>Total referrals: {{ $referrals->count() }}</p>
            <p>Total bonus earned: ${{ number_format($referrals->sum('bonus'), 2) }}</p>
            <a href="{{ route('user.referrals.index') }}" class="text-blue-600 hover:underline">View my referrals</a>
        </div>
    </div>

    <!-- Recent Trades -->
    <div data-aos="fade-up" data-aos-delay="400" class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-2">Recent Trades</h2>
        @if($recentTrades->isEmpty())
            <p>No trades yet.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-left">
                        <th class="py-2">Trader</th>
                        <th class="py-2">Pair</th>
                        <th class="py-2">Outcome</th>
                        <th class="py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTrades as $trade)
                        <tr class="border-b">
                            <td class="py-2">{{ $trade->trader->name }}</td>
                            <td class="py-2 {{ $trade->roi >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $trade->trade->symbol }}
                            </td>
                            <td class="py-2 {{ $trade->profit_loss_amount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $trade->profit_loss_amount }}
                            </td>
                            <td class="py-2">{{ $trade->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
</x-app-layout>



        
    <!-- Copy Trading Section -->
    <!--<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-2">Your Copy Trading</h2>
        @if($activeTrades->isEmpty())
            <p>You are currently not copying any trader.</p>
        @else
            <ul class="space-y-2">
                @foreach($activeTrades as $trade)
                    <li>
                        {{ $trade->trader->name }} — 
                        <span class="{{ $trade->roi >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trade->roi }}%
                        </span> on {{ $trade->created_at->format('M d, Y') }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>-->
