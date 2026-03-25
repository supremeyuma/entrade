<x-layouts.app>
<div class="max-w-4xl mx-auto rounded bg-white p-4 shadow sm:p-6">
    <h2 class="mb-4 text-xl font-bold sm:text-2xl">My Deposits</h2>

    @if ($deposits->isEmpty())
        <p>No deposits yet.</p>
    @else
        <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse text-sm">
            <thead>
                <tr>
                    <th class="border px-3 py-2">#</th>
                    <th class="border px-3 py-2">Amount</th>
                    <th class="border px-3 py-2">Currency</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deposits as $deposit)
                    <tr>
                        <td class="border px-3 py-2">{{ $deposit->id }}</td>
                        <td class="border px-3 py-2">{{ $deposit->amount }}</td>
                        <td class="border px-3 py-2">{{ $deposit->currency }}</td>
                        <td class="border px-3 py-2 capitalize">{{ $deposit->status }}</td>
                        <td class="border px-3 py-2">{{ $deposit->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @endif
</div>
</x-layouts.app>
