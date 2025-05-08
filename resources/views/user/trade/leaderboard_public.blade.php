@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Top 5 Traders</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Trader ID</th>
                <th>ROI (%)</th>
                <th>Win Rate (%)</th>
                <th>Subscribers</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
