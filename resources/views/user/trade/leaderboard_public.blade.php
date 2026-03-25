<x-layouts.app>
<div class="mx-auto max-w-5xl px-4 py-6">
    <h1 class="mb-4 text-xl font-bold sm:text-2xl">Top 5 Traders</h1>
    <div class="overflow-x-auto rounded bg-white shadow">
    <table class="min-w-full text-sm">
        <thead>
            <tr>
                <th class="px-3 py-3 text-left sm:px-4">Name</th>
                <th class="px-3 py-3 text-left sm:px-4">Trader ID</th>
                <th class="px-3 py-3 text-left sm:px-4">ROI (%)</th>
                <th class="px-3 py-3 text-left sm:px-4">Win Rate (%)</th>
                <th class="px-3 py-3 text-left sm:px-4">Subscribers</th>
            </tr>
        </thead>
        <tbody>
            @foreach($traders as $trader)
                <tr>
                    <td class="px-3 py-2 sm:px-4">{{ $trader->name }}</td>
                    <td class="px-3 py-2 sm:px-4">{{ $trader->trader_id }}</td>
                    <td class="px-3 py-2 sm:px-4">{{ $trader->roi }}</td>
                    <td class="px-3 py-2 sm:px-4">{{ $trader->win_rate }}</td>
                    <td class="px-3 py-2 sm:px-4">{{ $trader->subscribers }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</x-layouts.app>
