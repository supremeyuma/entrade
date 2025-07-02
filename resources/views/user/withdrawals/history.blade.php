
<x-layouts.app>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        {{-- Flash + Errors --}}
        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 p-4 rounded">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-800 p-4 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Withdrawal History --}}
        <div class="mt-10">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Withdrawal History</h3>
                @if ($withdrawals->isEmpty())
                    <div class="text-gray-600 dark:text-gray-300">You have no withdrawal history yet.</div>
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
                            <th class="px-4 py-2">Crypto</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">To</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($withdrawals as $withdrawal)
                            <tr>
                                <td class="px-4 py-2">{{ $withdrawal->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2">{{ $withdrawal->cryptocurrency }}</td>
                                <td class="px-4 py-2">{{ $withdrawal->amount }}</td>
                                <td class="px-4 py-2 truncate">{{ $withdrawal->wallet_address }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        @class([
                                            'bg-yellow-100 text-yellow-800' => $withdrawal->status === 'pending',
                                            'bg-green-100 text-green-800' => $withdrawal->status === 'completed',
                                            'bg-red-100 text-red-800' => $withdrawal->status === 'rejected',
                                            'bg-blue-100 text-blue-800' => $withdrawal->status === 'approved',
                                        ])
                                    ">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">No withdrawals yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        </div>
    </x-layouts.app>
