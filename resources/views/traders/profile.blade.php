@extends('layouts.app')

@section('content')
    <h1>{{ $trader->name }} ({{ $trader->trader_id }})</h1>
    <p>ROI: {{ $trader->roi }}%</p>
    <p>Win Rate: {{ $trader->win_rate }}%</p>
    <p>Total Subscribers: {{ $trader->subscriptions_count }}</p>
    <p>Total Trades: {{ $trader->trades_count }}</p>

    <a href="{{ route('user.subscribe', $trader->id) }}" class="btn btn-primary">Copy Trader</a>
@endsection
