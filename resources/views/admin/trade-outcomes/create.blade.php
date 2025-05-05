@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Add Trade Outcome</h1>

    <form action="{{ route('admin.tradeOutcomes.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="trader_id">Trader</label>
            <select name="trader_id" id="trader_id" class="form-control" required>
                <option value="">Select Trader</option>
                @foreach($traders as $trader)
                    <option value="{{ $trader->id }}">
                        {{ $trader->name }} ({{ $trader->trader_id }})
                    </option>
                @endforeach
            </select>
            @error('trader_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="percentage">Percentage Gain/Loss (%)</label>
            <input type="number" step="0.01" name="percentage" id="percentage" class="form-control" required>
            @error('percentage')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="description">Description (optional)</label>
            <textarea name="description" id="description" class="form-control"></textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Add Outcome</button>
    </form>
</div>
@endsection
