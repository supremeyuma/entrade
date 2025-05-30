<x-layouts.app>
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">My Deposits</h2>

    @if ($deposits->isEmpty())
        <p>No deposits yet.</p>
    @else
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr>
                    <th class="border p-2">#</th>
                    <th class="border p-2">Amount</th>
                    <th class="border p-2">Currency</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deposits as $deposit)
                    <tr>
                        <td class="border p-2">{{ $deposit->id }}</td>
                        <td class="border p-2">{{ $deposit->amount }}</td>
                        <td class="border p-2">{{ $deposit->currency }}</td>
                        <td class="border p-2 capitalize">{{ $deposit->status }}</td>
                        <td class="border p-2">{{ $deposit->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</x-layouts.app>
