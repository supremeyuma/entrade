<x-layouts.app>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Find a Trader</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('user.trade.search') }}" method="GET" class="mb-8">
            <div class="flex flex-col sm:flex-row gap-4 items-center">
                <label for="search" class="sr-only">Search Trader</label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    class="w-full sm:w-2/3 px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-400"
                    placeholder="Enter trader name or ID"
                    required
                >
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Search
                </button>
            </div>
        </form>

        @if(isset($traders) && $traders->count() > 0)
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Search Results</h2>

            <div class="space-y-4">
                @foreach($traders as $trader)
                    <div class="bg-white dark:bg-gray-800 rounded shadow p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $trader->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Trader ID: {{ $trader->trader_id }}</p>
                        </div>

                        <div class="mt-4 sm:mt-0 flex flex-wrap gap-2">
                            @if (!$user->subscriptions->contains('trader_id', $trader->id))
                                <a href="{{ route('user.trade.showSubscribeForm', $trader->id) }}"
                                   class="px-3 py-1 bg-indigo-500 text-white text-sm rounded hover:bg-indigo-600">
                                    Copy Trader
                                </a>
                            @else
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded">
                                    Subscribed
                                </span>
                            @endif

                            <!--<form method="POST" action="{{ route('user.traders.addToCompare', $trader->id) }}">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300">
                                    Add to Compare
                                </button>
                            </form>-->
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(isset($traders))
            <p class="text-gray-600 mt-4">No traders found.</p>
        @endif

        <!--<div class="mt-8 text-center">
            <a href="{{ route('user.traders.compare') }}"
               class="inline-block text-indigo-600 hover:underline">
                Compare Traders →
            </a>
        </div>-->
    </div>
</x-layouts.app>
