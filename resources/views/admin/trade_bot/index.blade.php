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

        <form action="{{ route('admin.trade-bot.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow" id="tradeBotForm">
            @csrf

            {{-- [ ... existing fields remain unchanged above ... ] --}}

            <h3 class="text-lg font-semibold mt-6 mb-2">Advanced Options</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- existing advanced options unchanged --}}
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
