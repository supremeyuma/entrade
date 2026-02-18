<x-layouts.app>
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Trade History</h1>

         {{-- Filters --}}
        <form method="GET" class="mb-6 flex flex-col sm:flex-row sm:items-end gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                    class="mt-1 block w-full border-gray-300 dark:bg-gray-800 rounded-md shadow-sm">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                    class="mt-1 block w-full border-gray-300 dark:bg-gray-800 rounded-md shadow-sm">
            </div>

            <div>
                <label for="trader_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Trader</label>
                <select name="trader_id" id="trader_id"
                        class="mt-1 block w-full border-gray-300 dark:bg-gray-800 rounded-md shadow-sm">
                    <option value="">All</option>
                    @foreach($traders as $trader)
                        <option value="{{ $trader->id }}" @selected(request('trader_id') == $trader->id)>
                            {{ $trader->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 items-end">
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow hover:bg-indigo-700">
                    Filter
                </button>
                <a href="{{ route('user.trade-history.export', request()->query()) }}"
                class="bg-green-600 text-white px-4 py-2 rounded-md shadow hover:bg-green-700">
                    Export CSV
                </a>
            </div>
        </form>

        @if($histories->count())
        <div class="w-full overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full whitespace-nowrap text-xs sm:text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 border-b">Date</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 border-b">Trader</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 border-b">Pair</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 border-b">Side</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-right border-b">Outcome (%)</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-right border-b">Profit/Loss</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 border-b">Entry / Exit</th>
                            </tr>
                                <!--<th class="px-3 sm:px-4 py-2 sm:py-3 text-right border-b">New Balance</th>-->
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 dark:text-gray-200">
                            @foreach($histories as $history)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-3 sm:px-4 py-2 sm:py-3 border-b">
                                        {{ $history->created_at->format('Y-m-d H:i') }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-2 sm:py-3 border-b">{{ $history->trader->name }}</td>
                                    <td class="px-3 sm:px-4 py-2 sm:py-3 text-right border-b">
                                        {{ $history->trade->symbol }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-2 sm:py-3 border-b">{{ $history->trade->type ?? $history->trade->trade_type ?? 'N/A' }}</td>
                                    <td class="px-3 sm:px-4 py-2 sm:py-3 text-right font-semibold {{ $history->roi >= 0 ? 'text-green-600' : 'text-red-600' }} border-b">
                                        {{ $history->roi }}%
                                    </td>
                                    <td class="px-3 sm:px-4 py-2 sm:py-3 text-right border-b">
                                        {{ number_format($history->profit_loss_amount, 2) }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-2 sm:py-3 border-b">
                                        {{ $history->trade->entry_timestamp ? \Carbon\Carbon::parse($history->trade->entry_timestamp)->format('Y-m-d H:i') : '-' }}
                                        /
                                        {{ $history->trade->exit_timestamp ? \Carbon\Carbon::parse($history->trade->exit_timestamp)->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    
                                    <!--<td class="px-3 sm:px-4 py-2 sm:py-3 text-right border-b">
                                        {{ number_format($history->amount_returned, 2) }}
                                    </td>-->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @else
            <p class="text-gray-600 dark:text-gray-300">You have no trade history yet.</p>
        @endif

    </div>
</x-layouts.app>
