<x-layouts.app>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Deposit History</h2>

        @if ($deposits->isEmpty())
            <div class="text-gray-600 dark:text-gray-300">You have no deposit history yet.</div>
        @else

        <!--FILTER FORM-->
        <form method="GET" class="mb-4 flex flex-wrap items-center gap-3">
                    <div>
                        <label class="text-sm text-gray-700 dark:text-gray-200">From</label>
                        <input type="date" name="from" value="{{ request('from') }}"
                            class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-2 py-1" />
                    </div>
                    <div>
                        <label class="text-sm text-gray-700 dark:text-gray-200">To</label>
                        <input type="date" name="to" value="{{ request('to') }}"
                            class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-2 py-1" />
                    </div>
                    <div>
                        <label class="text-sm text-gray-700 dark:text-gray-200">Sort By</label>
                        <select name="sort" onchange="this.form.submit()"
                                class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-2 py-1">
                            <option value="">Newest First</option>
                            <option value="date_asc" @selected(request('sort') === 'date_asc')>Oldest First</option>
                            <option value="amount_asc" @selected(request('sort') === 'amount_asc')>Amount ↑</option>
                            <option value="amount_desc" @selected(request('sort') === 'amount_desc')>Amount ↓</option>
                        </select>
                    </div>
                    <button type="submit"
                            class="ml-auto bg-blue-600 text-white px-4 py-1.5 rounded hover:bg-blue-700 transition">
                        Filter
                    </button>
                </form>
                 <!--FILTER FORM END-->
                 
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                        <tr>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Currency</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Invoice Link</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($deposits as $deposit)
                            <tr>
                                <td class="px-4 py-2">{{ $deposit->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-2">{{ number_format($deposit->amount, 2) }}</td>
                                <td class="px-4 py-2">{{ strtoupper($deposit->currency) }}</td>
                                <td class="px-4 py-2">
                                    <span class="{{ $deposit->status === 'confirmed' ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ ucfirst($deposit->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    @if ($deposit->status === 'confirmed')
                                        <a href="{{ $deposit->payment_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">View Invoice</a>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
