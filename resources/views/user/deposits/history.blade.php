<x-layouts.app>
    <div class="max-w-4xl mx-auto px-4 py-6 sm:px-6 sm:py-10 lg:px-8">
        <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-white sm:mb-6 sm:text-2xl">Deposit History</h2>

        @if ($deposits->isEmpty())
            <div class="text-gray-600 dark:text-gray-300">You have no deposit history yet.</div>
        @else

        <!--FILTER FORM-->
        <form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
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
                        <label class="text-sm text-gray-700 dark:text-gray-200">Status</label>
                        <select name="status" class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-2 py-1">
                            <option value="">All</option>
                            <option value="waiting" @selected(request('status')==='waiting')>Waiting</option>
                            <option value="finished" @selected(request('status')==='finished')>Finished</option>
                            <option value="rejected" @selected(request('status')==='rejected')>Rejected</option>
                        </select>
                    </div>
                    <button type="submit"
                            class="w-full rounded bg-blue-600 px-4 py-2 text-sm text-white transition hover:bg-blue-700 sm:ml-auto sm:w-auto sm:py-1.5">
                        Filter
                    </button>
                </form>
                 <!--FILTER FORM END-->
                 
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                        <tr>
                                @php
                                    $sort = request('sort');
                                    $dateSort = $sort === 'date_asc' ? 'date_desc' : 'date_asc';
                                    $amountSort = $sort === 'amount_asc' ? 'amount_desc' : 'amount_asc';
                                @endphp
                                <th class="px-3 py-2 sm:px-4">
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
                                <th class="px-3 py-2 sm:px-4">
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
                                <th class="px-3 py-2 sm:px-4">Currency</th>
                                <th class="px-3 py-2 sm:px-4">Status</th>
                                <th class="px-3 py-2 sm:px-4">Invoice Link</th>
                            </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($deposits as $deposit)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition" role="link" tabindex="0" data-href="{{ route('user.deposit.show', $deposit->id) }}">
                                <td class="px-3 py-2 sm:px-4">{{ $deposit->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ number_format($deposit->amount, 2) }}</td>
                                <td class="px-3 py-2 sm:px-4">{{ strtoupper($deposit->currency) }}</td>
                                <td class="px-3 py-2 sm:px-4">
                                    <span class="{{ $deposit->status === 'finished' ? 'text-green-600' : ($deposit->status === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                        {{ ucfirst($deposit->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 sm:px-4">
                                    @if (!empty($deposit->invoice_url))
                                        <a href="{{ $deposit->invoice_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">View Invoice</a>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-3 sm:p-4">
                    {{ $deposits->links('pagination::tailwind') }}
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.querySelectorAll('tr[data-href]').forEach(function (tr) {
                            tr.addEventListener('click', function () { window.location = tr.dataset.href; });
                            tr.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { window.location = tr.dataset.href; } });
                        });
                        document.querySelectorAll('table a').forEach(function (a) { a.addEventListener('click', function (e) { e.stopPropagation(); }); });
                    });
                </script>
            </div>
        @endif
    </div>
</x-layouts.app>
