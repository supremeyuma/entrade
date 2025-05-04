@extends('layouts.user')

@section('content')
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
                        <p>Trader ID: {{ $trader->unique_trader_id }}</p>
                        <a href="{{ route('user.trade.showSubscribeForm', $trader->id) }}" class="btn btn-success">
                            Subscribe
                        </a>
                    </div>
                </div>
            @endforeach
        @elseif(isset($traders))
            <p class="mt-3">No traders found.</p>
        @endif
    </div>
@endsection
