<x-layouts.admin>
<div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Trade Logs</h1>

        <a href="{{ route('admin.trade-logs.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">
            Add Trade
        </a>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-3 px-6 text-left">Trader</th>
                        <th class="py-3 px-6 text-left">Date</th>
                        <th class="py-3 px-6 text-left">SYMBOL</th>
                        <th class="py-3 px-6 text-left">ROI %</th>
                        <th class="py-3 px-6 text-left">Opened</th>
                        <th class="py-3 px-6 text-left">Closed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trades as $trade)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6">{{ $trade->trader->name }}</td>
                            <td class="py-4 px-6">{{ $trade->created_at }}</td>
                            <td class="py-4 px-6">{{ $trade->symbol }}</td>
                            <td class="py-4 px-6">{{ $trade->roi }}%</td>
                            <td class="py-4 px-6">{{ ($trade->entry_timestamp) }}</td>
                            <td class="py-4 px-6" >           </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
