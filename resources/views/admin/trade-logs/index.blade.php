<x-layouts.admin>
<div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Trade Logs</h1>

        <a href="{{ route('admin.trade-logs.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">
            Add Trade Log
        </a>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-3 px-6 text-left">Trader</th>
                        <th class="py-3 px-6 text-left">Date</th>
                        <th class="py-3 px-6 text-left">Result</th>
                        <th class="py-3 px-6 text-left">Change %</th>
                        <th class="py-3 px-6 text-left">Notes</th>
                        <th class="py-3 px-6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trade as $trade)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6">{{ $trade->trader->name }}</td>
                            <td class="py-4 px-6">{{ $log->entry_date->format('Y-m-d') }}</td>
                            <td class="py-4 px-6">{{ ucfirst($log->result) }}</td>
                            <td class="py-4 px-6">{{ $log->percentage_change }}%</td>
                            <td class="py-4 px-6">{{ Str::limit($log->notes, 50) }}</td>
                            <td class="py-4 px-6 flex space-x-2">
                                <a href="{{ route('admin.trade-logs.edit', $log) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('admin.trade-logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
