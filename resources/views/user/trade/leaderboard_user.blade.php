@extends('layouts.user')

@section('content')
<div class="container">
    <h1>Trader Leaderboard</h1>

    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name or ID">
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" name="min_roi" value="{{ request('min_roi') }}" class="form-control" placeholder="Min ROI">
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" name="min_win_rate" value="{{ request('min_win_rate') }}" class="form-control" placeholder="Min Win Rate">
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="roi" {{ request('sort') == 'roi' ? 'selected' : '' }}>Sort by ROI</option>
                    <option value="win_rate" {{ request('sort') == 'win_rate' ? 'selected' : '' }}>Sort by Win Rate</option>
                    <option value="subscribers" {{ request('sort') == 'subscribers' ? 'selected' : '' }}>Sort by Subscribers</option>
                    <option value="total_trades" {{ request('sort') == 'total_trades' ? 'selected' : '' }}>Sort by Total Trades</option>
                    <option value="avg_return_per_trade" {{ request('sort') == 'avg_return_per_trade' ? 'selected' : '' }}>Sort by Avg Return/Trade</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="direction" class="form-select">
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                </select>
            </div>
            <div class="col-md-12 mt-2">
                <button type="submit" class="btn btn-primary">Filter & Sort</button>
                <a href="{{ route('leaderboard.user') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Trader ID</th>
                <th>ROI (%)</th>
                <th>Win Rate (%)</th>
                <th>Subscribers</th>
                <th>Total Trades</th>
                <th>Avg Return/Trade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($traders as $trader)
                <tr>
                    <td>{{ $trader->name }}</td>
                    <td>{{ $trader->trader_id }}</td>
                    <td>{{ $trader->roi }}</td>
                    <td>{{ $trader->win_rate }}</td>
                    <td>{{ $trader->subscribers }}</td>
                    <td>{{ $trader->total_trades }}</td>
                    <td>{{ $trader->avg_return_per_trade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $traders->links() }}

    <a href="{{ route('leaderboard.user', array_merge(request()->query(), ['export' => 1])) }}" class="btn btn-success mt-3">Export CSV</a>
</div>
@endsection
