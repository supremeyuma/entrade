@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Trade Outcomes</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="mb-4">
        <div class="form-group">
            <label for="trader_id">Filter by Trader:</label>
            <select name="trader_id" id="trader_id" class="form-control">
                <option value="">All Traders</option>
                @foreach($traders as $trader)
                    <option value="{{ $trader->id }}" {{ request('trader_id') == $trader->id ? 'selected' : '' }}>
                        {{ $trader->name }} ({{ $trader->trader_id }})
                    </option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary mt-2">Filter</button>
    </form>

    <a href="{{ route('admin.trade-outcomes.create') }}" class="btn btn-success mb-3">Add New Trade Outcome</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Trader</th>
                <th>Percentage</th>
                <th>Description</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tradeOutcomes as $outcome)
                <tr>
                    <td>{{ $outcome->trader->name }} ({{ $outcome->trader->trader_id }})</td>
                    <td>{{ $outcome->percentage }}%</td>
                    <td>{{ $outcome->description ?? '-' }}</td>
                    <td>{{ $outcome->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No trade outcomes found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $tradeOutcomes->withQueryString()->links() }}
</div>
@endsection
