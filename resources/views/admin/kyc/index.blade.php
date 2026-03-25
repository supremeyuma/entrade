<x-layouts.admin>
    <div class="p-4 sm:p-6">
        <h1 class="mb-4 text-xl font-bold sm:text-2xl">KYC Submissions</h1>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto rounded-lg bg-white shadow dark:bg-gray-800">
        <table class="min-w-full overflow-hidden text-sm">
            <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                <tr>
                    <th class="px-3 py-2 sm:px-4">User</th>
                    <th class="px-3 py-2 sm:px-4">Status</th>
                    <th class="px-3 py-2 sm:px-4">Submitted</th>
                    <th class="px-3 py-2 sm:px-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kycs as $kyc)
                    <tr class="border-t dark:border-gray-700">
                        <td class="px-3 py-2 sm:px-4">{{ $kyc->user->name }} ({{ $kyc->user->email }})</td>
                        <td class="px-3 py-2 sm:px-4 capitalize">{{ $kyc->status }}</td>
                        <td class="px-3 py-2 sm:px-4">{{ $kyc->created_at->format('M d, Y') }}</td>
                        <td class="px-3 py-2 sm:px-4">
                            <a href="{{ route('admin.kyc.show', $kyc) }}" class="text-blue-600 hover:underline">Review</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-4 text-gray-500 text-center">No KYC submissions found.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="mt-4">
            {{ $kycs->links() }}
        </div>
    </div>
</x-layouts.admin>
