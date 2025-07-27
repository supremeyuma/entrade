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


        <form action="{{ route('admin.trade-bot.store') }}" method="POST" id="tradeBotForm" class="space-y-6 bg-white p-6 rounded-lg shadow">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" name="end_date" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Target ROI (%)</label>
                <input type="number" name="roi" step="0.1" min="0" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Market Types</label>
                <div class="mt-2 space-y-2">
                    @foreach (['forex' => 'Forex', 'crypto' => 'Crypto', 'stocks' => 'Stocks', 'indices' => 'Indices'] as $value => $label)
                        <label class="inline-flex items-center space-x-2">
                            <input type="checkbox" name="markets[]" value="{{ $value }}" class="form-checkbox text-indigo-600">
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Trading Pairs (optional)</label>
                <textarea name="trading_pairs" rows="3" placeholder="e.g. BTC/USDT, EUR/USD" class="mt-1 block w-full rounded border-gray-300 shadow-sm" ></textarea>
                <p class="text-xs text-gray-500 mt-1">Separate pairs with commas.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Assign To Trader (optional)</label>
                <select name="assign_to" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    <option value="">-- Do not assign --</option>
                    @foreach ($traders as $trader)
                        <option value="{{ $trader->id }}">{{ $trader->name }} (ID: {{ $trader->id }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="auto_run" class="form-checkbox text-indigo-600" value="1">
                    <span class="ml-2 text-sm text-gray-700">Auto-run this configuration immediately</span>
                </label>
            </div>

            <h3 class="text-lg font-semibold mt-6 mb-2">Advanced Options</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="timeframe">Trade Timeframe</label>
                    <select id="timeframe" name="timeframe" class="form-select w-full">
                        <option value="1min" {{ old('timeframe') == '1min' ? 'selected' : '' }}>1 Minute</option>
                        <option value="5min" {{ old('timeframe') == '5min' ? 'selected' : '' }}>5 Minutes</option>
                        <option value="15min" {{ old('timeframe') == '15min' ? 'selected' : '' }}>15 Minutes</option>
                        <option value="30min" {{ old('timeframe') == '30min' ? 'selected' : '' }}>30 Minutes</option>
                        <option value="60min" {{ old('timeframe', '1d') == '60min' ? 'selected' : '' }}>60 Minutes (1 Hour)</option>
                        <option value="1d" {{ old('timeframe', '1d') == '1d' ? 'selected' : '' }}>Daily</option>
                    </select>
            </div>

    <div>
        <label for="risk_per_trade">Risk per Trade (%)</label>
        <input type="number" step="0.1" min="0" max="100" name="risk_per_trade" class="form-input w-full" value="1.0" />
    </div>

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
            <div>
                <label class="inline-flex items-center mt-4">
                    <input type="checkbox" name="export_csv" class="form-checkbox text-indigo-600">
                    <span class="ml-2 text-sm text-gray-700">Export trades as CSV after generation</span>
                </label>
            </div>

            {{-- Preview ROI Simulation --}}
            <div class="pt-6 flex justify-between items-center">
                <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded shadow hover:bg-indigo-700">
                    Generate Trades
                </button>

                <button type="button" id="previewBtn" class="text-indigo-600 hover:underline text-sm">
                    Preview ROI Simulation
                </button>
            </div>
        </form>

        {{-- ROI Preview Summary --}}
        <div id="previewSummary" class="hidden mt-6 bg-gray-100 border border-gray-300 rounded p-4 shadow-sm">
            <h2 class="text-lg font-bold mb-2">Backtest Preview</h2>
            <ul class="text-sm space-y-1 text-gray-700">
                <li><strong>Estimated Trades:</strong> <span id="estTrades">...</span></li>
                <li><strong>Projected Win Rate:</strong> <span id="estWinRate">...</span>%</li>
                <li><strong>Expected ROI:</strong> <span id="estROI">...</span>%</li>
            </ul>
        </div>

       


    </div>

    {{-- ROI Preview Script --}}
    <script>
        document.getElementById('previewBtn').addEventListener('click', function () {
            const form = document.getElementById('tradeBotForm');
            const data = new FormData(form);

            fetch("{{ route('admin.trade-bot.preview') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: data
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('previewSummary').classList.remove('hidden');
                document.getElementById('estTrades').textContent = data.trade_count;
                document.getElementById('estWinRate').textContent = data.win_rate;
                document.getElementById('estROI').textContent = data.projected_roi;
            })
            .catch(err => alert("Failed to preview: " + err.message));
        });
    </script>
</x-layouts.admin>
