<x-layouts.app>
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Transaction History</h1>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b text-left">
                    <th class="py-2"><a href="?sort_by=created_at&direction={{ $sortBy === 'created_at' && $direction === 'asc' ? 'desc' : 'asc' }}">Date</a></th>
                    <th class="py-2"><a href="?sort_by=type&direction={{ $sortBy === 'type' && $direction === 'asc' ? 'desc' : 'asc' }}">Type</a></th>
                    <th class="py-2"><a href="?sort_by=category&direction={{ $sortBy === 'category' && $direction === 'asc' ? 'desc' : 'asc' }}">Details</a></th>
                    <th class="py-2"><a href="?sort_by=amount&direction={{ $sortBy === 'amount' && $direction === 'asc' ? 'desc' : 'asc' }}">Amount</a></th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                    <tr class="border-b">
                        <td class="py-2">{{ $tx->created_at->format('M d, Y H:i') }}</td>
                        <td class="py-2">{{ ucfirst($tx->type) }}</td>
                        <td class="py-2">{{ $tx->user_note ?? $tx->category ?? '-' }}</td>
                        <td class="py-2 {{ $tx->amount >= 0 ? 'text-green-600' : 'text-red-600' }}">${{ number_format($tx->amount, 2) }}</td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center">No transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
</x-layouts.app>
