<x-layouts.app>
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Deposit History</h2>

    @if($deposits->isEmpty())
        <div class="text-gray-600">You have no deposit history yet.</div>
    @else
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr>
                    <th class="border p-2 text-left">Date</th>
                    <th class="border p-2 text-left">Amount</th>
                    <th class="border p-2 text-left">Currency</th>
                    <th class="border p-2 text-left">Status</th>
                    <th class="border p-2 text-left">Invoice Link</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deposits as $deposit)
                    <tr>
                        <td class="border p-2">{{ $deposit->created_at->format('M d, Y') }}</td>
                        <td class="border p-2">{{ number_format($deposit->amount, 2) }}</td>
                        <td class="border p-2">{{ strtoupper($deposit->currency) }}</td>
                        <td class="border p-2">
                            <span class="{{ $deposit->status === 'confirmed' ? 'text-green-500' : 'text-yellow-500' }}">
                                {{ ucfirst($deposit->status) }}
                            </span>
                        </td>
                        <td class="border p-2">
                            @if ($deposit->status === 'confirmed')
                                <a href="{{ $deposit->payment_url }}" target="_blank" class="text-blue-500 hover:text-blue-700">View Invoice</a>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</x-layouts.app>
