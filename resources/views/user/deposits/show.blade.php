@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $headingClasses = $isDark ? 'text-slate-100' : 'text-slate-900';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
@endphp

<x-layouts.app>
    <div class="mx-auto max-w-4xl px-4 py-6 sm:py-8">
        <div class="space-y-4 sm:space-y-6">
            <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                    <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Funding</p>
                    <h2 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Deposit #{{ $deposit->id }}</h2>
                    <p class="mt-2 text-sm {{ $bodyTextClasses }}">Detailed deposit information, including status and invoice reference.</p>
                </div>
            </section>

            <div data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
                <dl class="divide-y divide-slate-200 dark:divide-slate-800">
                    <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                        <dt class="font-medium {{ $bodyTextClasses }}">Date</dt>
                        <dd class="{{ $headingClasses }}">{{ $deposit->created_at->format('M d, Y H:i:s') }}</dd>
                    </div>
                    <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                        <dt class="font-medium {{ $bodyTextClasses }}">Amount</dt>
                        <dd class="{{ $headingClasses }}">${{ number_format($deposit->amount,2) }}</dd>
                    </div>
                    <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                        <dt class="font-medium {{ $bodyTextClasses }}">Currency</dt>
                        <dd class="{{ $headingClasses }}">{{ strtoupper($deposit->currency) }}</dd>
                    </div>
                    <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                        <dt class="font-medium {{ $bodyTextClasses }}">Status</dt>
                        <dd class="{{ $headingClasses }}">{{ ucfirst($deposit->status) }}</dd>
                    </div>
                    <div class="flex flex-col gap-1 py-3 sm:flex-row sm:justify-between">
                        <dt class="font-medium {{ $bodyTextClasses }}">Invoice</dt>
                        <dd class="{{ $headingClasses }}">{{ $deposit->invoice_id }}</dd>
                    </div>
                    @if($deposit->admin_comment)
                    <div class="py-3">
                        <dt class="font-medium {{ $bodyTextClasses }}">Admin Comment</dt>
                        <dd class="mt-2 whitespace-pre-wrap {{ $headingClasses }}">{{ $deposit->admin_comment }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</x-layouts.app>
