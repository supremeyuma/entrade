<x-layouts.admin>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            Trade History for {{ $user->name }} (User #{{ $user->id }})
        </h2>

        <form method="GET" action="{{ route('admin.users.tradeHistories', $user->id) }}" class="mb-6 flex gap-4 items-end">
            <div class="flex-1">
                <label for="trader_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter by Trader</label>
                <select name="trader_id" id="trader_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">All Traders</option>
                    @foreach($traders as $trader)
                        <option value="{{ $trader->id }}" @selected(request('trader_id') == $trader->id)>
                            {{ $trader->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-shrink-0">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Filter
                </button>
            </div>
        </form>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        @php
                            $getSortDirection = function($column) use ($sortBy, $sortDirection) {
                                return $sortBy === $column && $sortDirection === 'asc' ? 'desc' : 'asc';
                            };
                        @endphp
                        
                        <th class="px-4 py-3">
                            <a href="{{ route('admin.users.tradeHistories', ['user' => $user->id, 'sort_by' => 'id', 'direction' => $getSortDirection('id')]) }}" class="flex items-center gap-1">
                                ID
                                @if($sortBy === 'id')
                                    <span>{!! $sortDirection === 'asc' ? '&#x25B2;' : '&#x25BC;' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3">Trader</th>
                        <th class="px-4 py-3">
                            <a href="{{ route('admin.users.tradeHistories', ['user' => $user->id, 'sort_by' => 'amount_invested', 'direction' => $getSortDirection('amount_invested')]) }}" class="flex items-center gap-1">
                                Amount Invested
                                @if($sortBy === 'amount_invested')
                                    <span>{!! $sortDirection === 'asc' ? '&#x25B2;' : '&#x25BC;' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3">
                             <a href="{{ route('admin.users.tradeHistories', ['user' => $user->id, 'sort_by' => 'roi', 'direction' => $getSortDirection('roi')]) }}" class="flex items-center gap-1">
                                ROI (%)
                                @if($sortBy === 'roi')
                                    <span>{!! $sortDirection === 'asc' ? '&#x25B2;' : '&#x25BC;' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3">
                            <a href="{{ route('admin.users.tradeHistories', ['user' => $user->id, 'sort_by' => 'amount_returned', 'direction' => $getSortDirection('amount_returned')]) }}" class="flex items-center gap-1">
                                Amount Returned
                                @if($sortBy === 'amount_returned')
                                    <span>{!! $sortDirection === 'asc' ? '&#x25B2;' : '&#x25BC;' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3">
                             <a href="{{ route('admin.users.tradeHistories', ['user' => $user->id, 'sort_by' => 'new_trade_balance', 'direction' => $getSortDirection('new_trade_balance')]) }}" class="flex items-center gap-1">
                                Balance
                                @if($sortBy === 'new_trade_balance')
                                    <span>{!! $sortDirection === 'asc' ? '&#x25B2;' : '&#x25BC;' !!}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3">
                            <a href="{{ route('admin.users.tradeHistories', ['user' => $user->id, 'sort_by' => 'created_at', 'direction' => $getSortDirection('created_at')]) }}" class="flex items-center gap-1">
                                Created
                                @if($sortBy === 'created_at')
                                    <span>{!! $sortDirection === 'asc' ? '&#x25B2;' : '&#x25BC;' !!}</span>
                                @endif
                            </a>
                        </th>
                    </tr>
                </thead>
                        <!--<th class="px-4 py-3">Closed</th>-->
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-100 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($tradeHistories as $history)
                        <tr>
                            <td class="px-4 py-2">#{{ $history->id }}</td>
                            <td class="px-4 py-2">{{ $history->trader->name ?? '-' }}</td>
                            <td class="px-4 py-2">${{ number_format($history->amount_invested, 2) }}</td>
                            <td class="px-4 py-2">{{ $history->roi }}%</td>
                            <td class="px-4 py-2">${{ number_format($history->amount_returned, 2) }}</td>
                            <td class="px-4 py-2">${{ number_format($history->new_trade_balance, 2) }}</td>
                            <td class="px-4 py-2">{{ $history->created_at ?? '-' }}</td>
                            <!--<td class="px-4 py-2">{{ $history->trade->exit_timestamp ?? '-' }}</td>-->
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No trade history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $tradeHistories->links() }}
        </div>
    </div>
</x-layouts.admin>
