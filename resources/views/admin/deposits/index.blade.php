<x-layouts.admin>
    <div class="px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Deposits</h1>

        <form method="GET" class="mb-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
            <input type="text" name="q" placeholder="Search user or invoice" value="{{ request('q') }}" class="px-3 py-2 rounded border" />
            <select name="status" class="px-3 py-2 rounded border">
                <option value="">All statuses</option>
                <option value="waiting" {{ request('status')=='waiting' ? 'selected' : '' }}>Waiting</option>
                <option value="finished" {{ request('status')=='finished' ? 'selected' : '' }}>Finished</option>
                <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 rounded border" />
            <div class="flex gap-2">
                <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 rounded border" />
                <button class="px-3 py-2 bg-indigo-600 text-white rounded">Filter</button>
            </div>
        </form>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">User</th>
                        @php
                            $sort = request('sort');
                            $dateSort = $sort === 'date_asc' ? 'date_desc' : 'date_asc';
                            $amountSort = $sort === 'amount_asc' ? 'amount_desc' : 'amount_asc';
                        @endphp
                        <th class="px-4 py-3">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $dateSort]) }}" class="inline-flex items-center gap-1">
                                Date
                                @if($sort === 'date_asc')
                                    <svg class="w-3 h-3" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                        <path d="M5 12l5-5 5 5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                @elseif($sort === 'date_desc')
                                    <svg class="w-3 h-3" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                        <path d="M5 8l5 5 5-5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $amountSort]) }}" class="inline-flex items-center gap-1">
                                Amount
                                @if($sort === 'amount_asc')
                                    <svg class="w-3 h-3" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                        <path d="M5 12l5-5 5 5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                @elseif($sort === 'amount_desc')
                                    <svg class="w-3 h-3" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                        <path d="M5 8l5 5 5-5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-3">Invoice</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($deposits as $d)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-4 py-3">{{ $d->user->name ?? '—' }}<br/><span class="text-xs text-gray-500">{{ $d->user->email ?? '' }}</span></td>
                            <td class="px-4 py-3">{{ $d->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3">${{ number_format($d->amount,2) }}</td>
                            <td class="px-4 py-3">{{ $d->invoice_id }}</td>
                            <td class="px-4 py-3">{{ ucfirst($d->status) }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.deposits.show', $d->id) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-indigo-600 rounded-lg">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $deposits->links('pagination::tailwind') }}
        </div>
    </div>
</x-layouts.admin>
