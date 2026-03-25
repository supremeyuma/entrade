<x-layouts.admin>
<h1 class="mb-4 text-xl sm:text-2xl">{{ isset($tradeLog) ? 'Edit' : 'Add' }} Trade Log</h1>

    <form action="{{ isset($tradeLog) ? route('admin.trade-logs.update', $tradeLog) : route('admin.trade-logs.store') }}" method="POST">
        @csrf
        @if(isset($tradeLog))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label>Trader</label>
            <select name="trader_id" class="input" required>
                <option value="">Select Trader</option>
                @foreach ($traders as $trader)
                    <option value="{{ $trader->id }}" {{ old('trader_id', $tradeLog->trader_id ?? '') == $trader->id ? 'selected' : '' }}>
                        {{ $trader->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label>Entry Date</label>
            <input type="date" name="entry_date" value="{{ old('entry_date', isset($tradeLog) ? $tradeLog->entry_date->format('Y-m-d') : '') }}" class="input" required>
        </div>

        <div class="mb-4">
            <label>Result</label>
            <select name="result" class="input" required>
                <option value="win" {{ old('result', $tradeLog->result ?? '') == 'win' ? 'selected' : '' }}>Win</option>
                <option value="loss" {{ old('result', $tradeLog->result ?? '') == 'loss' ? 'selected' : '' }}>Loss</option>
            </select>
        </div>

        <div class="mb-4">
            <label>Percentage Change (%)</label>
            <input type="number" step="0.01" name="percentage_change" value="{{ old('percentage_change', $tradeLog->percentage_change ?? '') }}" class="input" required>
        </div>

        <div class="mb-4">
            <label>Notes</label>
            <textarea name="notes" class="input">{{ old('notes', $tradeLog->notes ?? '') }}</textarea>
        </div>

        <button class="btn btn-primary">{{ isset($tradeLog) ? 'Update' : 'Create' }}</button>
    </form>
</x-layouts.admin>
