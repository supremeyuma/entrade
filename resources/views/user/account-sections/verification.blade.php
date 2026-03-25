<div class="space-y-4 rounded-[24px] border border-slate-200 bg-white p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:rounded-[28px] sm:p-6 sm:space-y-6">
    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100 sm:text-xl">Identity Verification (KYC)</h2>

    @if(session('kyc_success'))
        <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
            {{ session('kyc_success') }}
        </div>
    @endif

    @if($errors->kyc && $errors->kyc->any())
        <div class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->kyc->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-3 text-sm text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 sm:p-4">
        <p class="text-sm">
            <strong>Status:</strong>
            @if($kyc && $kyc->status === 'verified')
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Verified</span>
            @elseif($kyc && $kyc->status === 'pending')
                <span class="font-semibold text-amber-600 dark:text-amber-400">Pending Review</span>
            @elseif($kyc && $kyc->status === 'rejected')
                <span class="font-semibold text-rose-600 dark:text-rose-400">Rejected</span>
            @else
                <span class="font-semibold text-slate-500 dark:text-slate-400">Not Submitted</span>
            @endif
        </p>
        @if($kyc && $kyc->status === 'rejected' && $kyc->rejection_reason)
            <p class="mt-2 text-sm text-rose-500"><strong>Reason:</strong> {{ $kyc->rejection_reason }}</p>
        @endif
    </div>

    @if(!$kyc || in_array($kyc->status, ['rejected', 'not_submitted']))
        <form method="POST" action="{{ route('user.kyc.submit') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">ID Document (Passport, National ID, Driver's License)</label>
                <input type="file" name="id_document" accept="image/*,application/pdf"
                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Proof of Address (Utility bill, bank statement, etc.)</label>
                <input type="file" name="proof_of_address" accept="image/*,application/pdf"
                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            </div>
            <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
                Submit for Verification
            </button>
        </form>
    @elseif($kyc->status === 'pending')
        <p class="text-sm text-slate-600 dark:text-slate-300">Your documents are being reviewed. You will be notified upon verification.</p>
    @endif
</div>
