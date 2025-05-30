<x-layouts.app>
<div class="container">
        <h1>Find a Trader</h1>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('user.trade.search') }}" method="GET">
            <div class="form-group">
                <label for="search">Search Trader (Name or Trader ID)</label>
                <input type="text" name="search" id="search" class="form-control" placeholder="Enter name or ID" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </form>

        @if(isset($traders) && $traders->count() > 0)
            <h2 class="mt-4">Search Results</h2>
            @foreach($traders as $trader)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>{{ $trader->name }}</h5>
                        <p>Trader ID: {{ $trader->trader_id }}</p>
                        <!--<a href="{{ route('user.trade.showSubscribeForm', $trader->id) }}" class="btn btn-success">
                            Subscribe
                        </a>-->
                        @if (!$user->subscriptions->contains('trader_id', $trader->id))
                                <a href="{{ route('user.trade.showSubscribeForm', $trader->id) }}" class="btn btn-sm btn-primary">
                                    Copy Trader
                                </a>
                            @else
                                <span class="badge badge-success">Subscribed</span>
                            @endif

                            <form method="POST" action="{{ route('user.traders.addToCompare', $trader->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-secondary">Add to Compare</button>
                            </form>
                    </div>
                </div>
            @endforeach
        @elseif(isset($traders))
            <p class="mt-3">No traders found.</p>
        @endif

        <a href="{{ route('user.traders.compare') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Compare Traders</a>

    </div>
</x-layouts.app>
