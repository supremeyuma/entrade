<x-layouts.admin>
    <div class="px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Traders</h1>
            <a href="{{ route('admin.traders.create') }}" class="btn btn-primary">+ Add Trader</a>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded">
            <table class="table-auto w-full text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2 text-left">Photo</th>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Bio</th>
                        <th class="px-4 py-2 text-left">Performance</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($traders as $trader)
                        <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3">
                                @if($trader->profile_photo)
                                    <img src="{{ asset('storage/' . $trader->profile_photo) }}"
                                         alt="Photo"
                                         class="w-10 h-10 rounded-full object-cover">
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium">{{ $trader->name }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                {{ Str::limit($trader->bio, 50) }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col gap-1 text-xs text-gray-700 dark:text-gray-200">
                                    @php
                                        $metrics = $trader->performance_metrics ?? [];
                                    @endphp
                                    @if ($metrics)
                                        @foreach ($metrics as $label => $value)
                                            <div><span class="font-semibold">{{ ucfirst($label) }}:</span> {{ $value }}</div>
                                        @endforeach
                                    @else
                                        <span class="italic text-gray-400">N/A</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.traders.show', $trader) }}"
                                       class="btn btn-xs btn-secondary">View</a>
                                    <a href="{{ route('admin.traders.edit', $trader) }}"
                                       class="btn btn-xs btn-warning">Edit</a>
                                    <form action="{{ route('admin.traders.destroy', $trader) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure?')"
                                          class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">No traders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
