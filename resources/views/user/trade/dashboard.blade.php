<x-layouts.app>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">My Copied Traders</h2>

        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <p class="text-gray-700">💰 <span class="font-semibold">Main Balance:</span> ${{ number_format($user->balance->main_balance, 2) }}</p>
            <p class="text-gray-700">📈 <span class="font-semibold">Trading Balance:</span> ${{ number_format($user->balance->trade_balance, 2) }}</p>
        </div>

        @if($subscriptions->isEmpty())
            <div class="bg-yellow-100 text-yellow-800 rounded p-4 text-sm">
                You are not copying any traders yet.
            </div>
        @else
            @if(session('success'))
                <div class="bg-green-100 text-green-800 rounded p-4 text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="text-xl font-medium mb-4">Your Trader Subscriptions</h3>

            @foreach ($user->traderSubscriptions as $subscription)
                @if($subscription->status == 'active')
                    <div class="bg-white shadow rounded-lg p-5 mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h4 class="text-lg font-semibold text-indigo-600">{{ $subscription->trader->name }}</h4>
                                <p class="text-sm text-gray-600">Allocated Amount: ${{ $subscription->allocated_amount }}</p>
                            </div>

                            <button>
                                <a href="{{ route('user.trader.outcome.show', $subscription->trader->id) }}" class="text-indigo-600 hover:underline text-sm" >View Outcomes</a>
                            </button>

                            <form action="{{ route('user.unsubscribe', $subscription->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-600 hover:underline text-sm">Unsubscribe</button>
                            </form>
                        </div>

                        <form action="{{ route('user.updateAllocation', $subscription->id) }}" method="POST" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @csrf
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Change Allocation</label>
                                <input type="number" name="amount" id="amount" min="1"
                                    value="{{ $subscription->allocated_amount }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                    Update Allocation
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-white shadow rounded-lg p-5 mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h4 class="text-lg font-semibold text-indigo-600">{{ $subscription->trader->name }} is not ACTIVE</h4>
                                <!--<p class="text-sm text-gray-600">Allocated Amount: ${{ $subscription->allocated_amount }}</p>-->
                            </div>
                            <form action="{{ route('user.trade.showSubscribeForm', $subscription->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="text-green-600 hover:underline text-sm">SUBSCRIBE</button>
                            </form>
                        </div>

                        <!--<form action="{{ route('user.updateAllocation', $subscription->id) }}" method="POST" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @csrf
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Change Allocation</label>
                                <input type="number" name="amount" id="amount" min="1"
                                    value="{{ $subscription->allocated_amount }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                    Update Allocation
                                </button>
                            </div>
                        </form>-->
                    </div>
                @endif
            @endforeach

            <h3 class="text-xl font-medium mb-4 mt-10">Transfer Funds Between Balances</h3>

            <form action="{{ route('user.transferFunds') }}" method="POST" class="bg-white shadow rounded-lg p-5">
                @csrf
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                        <input type="number" name="amount" id="amount" min="1" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="transfer_type" class="block text-sm font-medium text-gray-700">Transfer Type</label>
                        <select name="transfer_type" id="transfer_type" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="main_to_trade">Main Balance to Trade Balance</option>
                            <option value="trade_to_main">Trade Balance to Main Balance</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit"
                            class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Transfer Funds
                    </button>
                </div>
            </form>
        @endif
    </div>
</x-layouts.app>
