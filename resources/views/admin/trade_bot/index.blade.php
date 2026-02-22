<x-layouts.admin>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Generate Historical Trades</h1>

        {{-- Flash Success Message --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-800 rounded shadow">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('admin.trade-bot.generate') }}" method="POST" id="tradeBotForm" class="space-y-6 bg-white p-6 rounded-lg shadow">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" name="end_date" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>

            {{-- Target ROI and Market Types removed — Net Profit only is required. --}}

            <div>
                <label class="block text-sm font-medium text-gray-700">Trading Pairs (optional)</label>
                <textarea name="trading_pairs" rows="3" placeholder="e.g. BTC/USDT, EUR/USD" class="mt-1 block w-full rounded border-gray-300 shadow-sm" ></textarea>
                <p class="text-xs text-gray-500 mt-1">Separate pairs with commas.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Select User</label>
                <select name="user_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                    <option value="">-- Select user --</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Net Profit (currency)</label>
                <input type="number" name="net_profit" step="0.01"  class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>

            <!--<div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="auto_run" class="form-checkbox text-indigo-600" value="1">
                    <span class="ml-2 text-sm text-gray-700">Auto-run this configuration immediately</span>
                </label>
            </div>-->

            <h3 class="text-lg font-semibold mt-6 mb-2">Advanced Options</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!--<div>
                <label for="timeframe">Trade Timeframe</label>
                    <select id="timeframe" name="interval" class="form-select w-full">
                        <option value="1min" {{ old('timeframe') == '1min' ? 'selected' : '' }}>1 Minute</option>
                        <option value="5min" {{ old('timeframe') == '5min' ? 'selected' : '' }}>5 Minutes</option>
                        <option value="15min" {{ old('timeframe') == '15min' ? 'selected' : '' }}>15 Minutes</option>
                        <option value="30min" {{ old('timeframe') == '30min' ? 'selected' : '' }}>30 Minutes</option>
                        <option value="60min" {{ old('timeframe', '1d') == '60min' ? 'selected' : '' }}>60 Minutes (1 Hour)</option>
                        <option value="1d" {{ old('timeframe', '1d') == '1d' ? 'selected' : '' }}>Daily</option>
                    </select>
            </div>-->

    <!--<div>
        <label for="risk_per_trade">Risk per Trade (%)</label>
        <input type="number" step="0.1" min="0" max="100" name="risk_per_trade" class="form-input w-full" value="1.0" />
    </div>-->

    <div>
        <label for="desired_win_rate">Desired Win Rate (%)</label>
        <input type="number" step="0.1" min="0" max="100" name="desired_win_rate" class="form-input w-full" placeholder="Optional" />
    </div>

    <div>
        <label for="max_trades">Maximum Trades (cap)</label>
        <input type="number" min="1" name="max_trades" class="form-input w-full" placeholder="Optional" />
    </div>
</div>

            

            {{-- Export to CSV --}}
            <!--<div>
                <label class="inline-flex items-center mt-4">
                    <input type="checkbox" name="export_csv" class="form-checkbox text-indigo-600">
                    <span class="ml-2 text-sm text-gray-700">Export trades as CSV after generation</span>
                </label>
            </div>-->

            <div class="pt-6">
                <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded shadow hover:bg-indigo-700">
                    Generate Trades
                </button>
            </div>
        </form>
    </div>

</x-layouts.admin>
