<x-layouts.admin>
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-100 sm:mb-6 sm:text-2xl">Trade Outcomes</h1>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <label for="trader_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Trader</label>
                    <select name="trader_id" id="trader_id"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Traders</option>
                        @foreach($traders as $trader)
                            <option value="{{ $trader->id }}" {{ request('trader_id') == $trader->id ? 'selected' : '' }}>
                                {{ $trader->name }} ({{ $trader->trader_id }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="self-end">
                    <button type="submit" class="inline-flex min-h-[40px] items-center rounded bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-indigo-700">
                        Filter
                    </button>
                </div>
            </div>
        </form>

        <div class="mb-4">
            <a href="{{ route('admin.trade-outcomes.create') }}" class="inline-flex min-h-[40px] items-center rounded bg-green-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-green-700">
                + Add New Trade Outcome
            </a>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Trader</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Percentage</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Created At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($tradeOutcomes as $outcome)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                {{ $outcome->trader->name }} <br>
                                <span class="text-xs text-gray-500">(ID: {{ $outcome->trader->trader_id }})</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-indigo-600 dark:text-indigo-400 font-semibold">
                                {{ $outcome->percentage }}%
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ $outcome->description ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                {{ $outcome->created_at->format('Y-m-d H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500 dark:text-gray-400">
                                No trade outcomes found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $tradeOutcomes->withQueryString()->links() }}
        </div>
    </div>
</x-layouts.admin>
