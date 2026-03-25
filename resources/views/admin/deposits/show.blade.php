<x-layouts.admin>
    @php
        $isDark = session('theme', 'light') === 'dark';
        $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-white' : 'border-slate-200 bg-white text-slate-900';
        $heroOverlayClasses = $isDark
            ? 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.18),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.18),_transparent_26%),linear-gradient(135deg,_#020617,_#0f172a_58%,_#111827)]'
            : 'bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
        $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
        $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
        $mutedTextClasses = $isDark ? 'text-slate-400' : 'text-slate-500';
        $inputClasses = $isDark
            ? 'border-slate-700 bg-slate-800 text-slate-100 focus:border-emerald-400 focus:ring-emerald-500/20'
            : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-400 focus:ring-emerald-200';
    @endphp

    <div class="space-y-3 sm:space-y-6">
        <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative">
                    <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Deposit #{{ $deposit->id }}</h1>
                    <p class="mt-1 text-[11px] sm:mt-2 sm:text-sm {{ $mutedTextClasses }}">Review payment details and approve or reject the incoming deposit.</p>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="100" class="max-w-4xl rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <dl class="divide-y divide-slate-200 dark:divide-slate-800">
                <div class="flex justify-between gap-4 py-3">
                    <dt class="font-medium {{ $mutedTextClasses }}">User</dt>
                    <dd class="{{ $headingClasses }}">{{ $deposit->user->name ?? '-' }}<br/><span class="text-xs {{ $mutedTextClasses }}">{{ $deposit->user->email ?? '' }}</span></dd>
                </div>
                <div class="flex justify-between gap-4 py-3">
                    <dt class="font-medium {{ $mutedTextClasses }}">Date</dt>
                    <dd class="{{ $headingClasses }}">{{ $deposit->created_at->format('M d, Y H:i:s') }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-3">
                    <dt class="font-medium {{ $mutedTextClasses }}">Amount</dt>
                    <dd class="{{ $headingClasses }}">${{ number_format($deposit->amount,2) }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-3">
                    <dt class="font-medium {{ $mutedTextClasses }}">Invoice</dt>
                    <dd class="{{ $headingClasses }}">{{ $deposit->invoice_id }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-3">
                    <dt class="font-medium {{ $mutedTextClasses }}">Status</dt>
                    <dd class="{{ $headingClasses }}">{{ ucfirst($deposit->status) }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-3">
                    <dt class="font-medium {{ $mutedTextClasses }}">Received Amount</dt>
                    <dd class="{{ $headingClasses }}">${{ number_format($deposit->received_amount ?? 0,2) }}</dd>
                </div>
                @if($deposit->admin_comment)
                <div class="flex justify-between gap-4 py-3">
                    <dt class="font-medium {{ $mutedTextClasses }}">Admin Comment</dt>
                    <dd class="whitespace-pre-wrap {{ $headingClasses }}">{{ $deposit->admin_comment }}</dd>
                </div>
                @endif
            </dl>

            @if($deposit->status !== 'finished')
                <div class="mt-5 grid grid-cols-1 gap-3 sm:mt-6 sm:grid-cols-2 sm:gap-4">
                    <form action="{{ route('admin.deposits.approve', $deposit->id) }}" method="POST" class="rounded-[18px] bg-emerald-50 p-4 shadow-sm dark:bg-emerald-500/10">
                        @csrf
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Received Amount (optional)</label>
                        <input type="number" step="0.01" name="received_amount" class="mb-2 w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}" value="{{ old('received_amount', $deposit->received_amount ?? $deposit->amount) }}">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Comment (optional)</label>
                        <textarea name="admin_comment" rows="3" class="mb-2 w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}"></textarea>
                        <button class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">Approve & Credit</button>
                    </form>

                    <form action="{{ route('admin.deposits.reject', $deposit->id) }}" method="POST" class="rounded-[18px] bg-rose-50 p-4 shadow-sm dark:bg-rose-500/10">
                        @csrf
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Rejection Reason (optional)</label>
                        <textarea name="admin_comment" rows="3" class="mb-2 w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}"></textarea>
                        <button class="w-full rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">Reject</button>
                    </form>
                </div>
            @endif
        </section>
    </div>
</x-layouts.admin>
