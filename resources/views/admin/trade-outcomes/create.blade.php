<x-layouts.admin>
<div class="mx-auto max-w-3xl px-4 py-6">
    <h1 class="mb-4 text-xl font-semibold sm:text-2xl">Add Trade Outcome</h1>

    <form action="{{ route('admin.trade-outcomes.store') }}" method="POST" class="rounded bg-white p-4 shadow sm:p-6">
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

        <button type="submit" class="mt-2 w-full rounded bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700 sm:w-auto">Add Outcome</button>
    </form>
</div>
</x-layouts.admin>
