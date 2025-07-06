<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-6">
    <h2 class="text-xl font-semibold">Identity Verification (KYC)</h2>

    {{-- Flash Message --}}
    @if(session('kyc_success'))
        <div class="bg-green-100 text-green-800 dark:bg-green-700 dark:text-white px-4 py-3 rounded">
            {{ session('kyc_success') }}
        </div>
    @endif

    @if($errors->kyc && $errors->kyc->any())
        <div class="bg-red-100 text-red-800 dark:bg-red-700 dark:text-white px-4 py-3 rounded">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->kyc->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Current Status -->
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded border">
        <p class="text-sm">
            <strong>Status:</strong>
            @if($kyc && $kyc->status === 'verified')
                <span class="text-green-600 font-semibold">Verified</span>
            @elseif($kyc && $kyc->status === 'pending')
                <span class="text-yellow-600 font-semibold">Pending Review</span>
            @elseif($kyc && $kyc->status === 'rejected')
                <span class="text-red-600 font-semibold">Rejected</span>
            @else
                <span class="text-gray-500 font-semibold">Not Submitted</span>
            @endif
        </p>
        @if($kyc && $kyc->status === 'rejected' && $kyc->rejection_reason)
            <p class="text-sm mt-2 text-red-400"><strong>Reason:</strong> {{ $kyc->rejection_reason }}</p>
        @endif
    </div>

    <!-- Upload Form -->
    @if(!$kyc || in_array($kyc->status, ['rejected', 'not_submitted']))
        <form method="POST" action="{{ route('user.kyc.submit') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">ID Document (Passport, National ID, Driver's License)</label>
                <input type="file" name="id_document" accept="image/*,application/pdf"
                       class="block w-full text-sm text-gray-700 dark:text-white border rounded dark:bg-gray-700">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Proof of Address (Utility bill, bank statement, etc.)</label>
                <input type="file" name="proof_of_address" accept="image/*,application/pdf"
                       class="block w-full text-sm text-gray-700 dark:text-white border rounded dark:bg-gray-700">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Submit for Verification
            </button>
        </form>
    @elseif($kyc->status === 'pending')
        <p class="text-sm text-gray-600 dark:text-gray-300">Your documents are being reviewed. You will be notified upon verification.</p>
    @endif
</div>
