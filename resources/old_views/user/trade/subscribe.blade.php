@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Subscribe to {{ $trader->name }}</h1>
        <p>Trader ID: {{ $trader->unique_trader_id }}</p>

        <form action="{{ route('user.subscribe', $trader->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="amount">Amount to Allocate</label>
                <input type="number" name="amount" id="amount" class="form-control" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Subscribe</button>
        </form>
    </div>
@endsection
