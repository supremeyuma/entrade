<x-layouts.admin>
    <div class="max-w-3xl mx-auto p-4 sm:p-6">
        <h1 class="mb-4 text-xl font-bold sm:mb-6 sm:text-2xl">KYC Review</h1>

        <div class="space-y-4">
            <p><strong>User:</strong> {{ $kyc->user->name }} ({{ $kyc->user->email }})</p>
            <p><strong>Status:</strong> <span class="capitalize">{{ $kyc->status }}</span></p>
            @if($kyc->rejection_reason)
                <p class="text-red-600"><strong>Reason:</strong> {{ $kyc->rejection_reason }}</p>
            @endif

            <div class="space-y-2">
                <p><strong>ID Document:</strong></p>
                <a href="{{ asset('storage/' . $kyc->id_document) }}" target="_blank" class="text-blue-600 underline">
                    View ID Document
                </a>
            </div>

            <div class="space-y-2">
                <p><strong>Proof of Address:</strong></p>
                <a href="{{ asset('storage/' . $kyc->proof_of_address) }}" target="_blank" class="text-blue-600 underline">
                    View Proof of Address
                </a>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:space-x-4">
            <form method="POST" action="{{ route('admin.kyc.approve', $kyc) }}">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Approve</button>
            </form>

            <form method="POST" action="{{ route('admin.kyc.reject', $kyc) }}">
                @csrf
                <input type="text" name="reason" placeholder="Rejection reason" required
                       class="px-3 py-2 border rounded dark:bg-gray-800 dark:text-white">
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-2">Reject</button>
            </form>
        </div>
    </div>
</x-layouts.admin>
