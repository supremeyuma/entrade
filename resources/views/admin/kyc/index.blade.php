<x-layouts.admin>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">KYC Submissions</h1>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
        @endif

        <table class="min-w-full bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden text-sm">
            <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                <tr>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Submitted</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kycs as $kyc)
                    <tr class="border-t dark:border-gray-700">
                        <td class="px-4 py-2">{{ $kyc->user->name }} ({{ $kyc->user->email }})</td>
                        <td class="px-4 py-2 capitalize">{{ $kyc->status }}</td>
                        <td class="px-4 py-2">{{ $kyc->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.kyc.show', $kyc) }}" class="text-blue-600 hover:underline">Review</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-4 text-gray-500 text-center">No KYC submissions found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $kycs->links() }}
        </div>
    </div>
</x-layouts.admin>
