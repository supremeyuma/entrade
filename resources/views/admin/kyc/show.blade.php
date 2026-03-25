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

    <div class="space-y-3 sm:space-y-6 max-w-4xl mx-auto">
        <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative">
                    <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">KYC Review</h1>
                </div>
            </div>
        </section>

        <section data-aos="fade-up" data-aos-delay="100" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
            <div class="space-y-4 text-sm {{ $headingClasses }}">
                <p><strong class="{{ $mutedTextClasses }}">User:</strong> {{ $kyc->user->name }} ({{ $kyc->user->email }})</p>
                <p><strong class="{{ $mutedTextClasses }}">Status:</strong> <span class="capitalize">{{ $kyc->status }}</span></p>
                @if($kyc->rejection_reason)
                    <p class="text-rose-600 dark:text-rose-400"><strong>Reason:</strong> {{ $kyc->rejection_reason }}</p>
                @endif

                <div class="space-y-2">
                    <p><strong class="{{ $mutedTextClasses }}">ID Document:</strong></p>
                    <a href="{{ asset('storage/' . $kyc->id_document) }}" target="_blank" class="text-sky-600 underline">
                        View ID Document
                    </a>
                </div>

                <div class="space-y-2">
                    <p><strong class="{{ $mutedTextClasses }}">Proof of Address:</strong></p>
                    <a href="{{ asset('storage/' . $kyc->proof_of_address) }}" target="_blank" class="text-sky-600 underline">
                        View Proof of Address
                    </a>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                <form method="POST" action="{{ route('admin.kyc.approve', $kyc) }}">
                    @csrf
                    <button type="submit" class="rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]">Approve</button>
                </form>

                <form method="POST" action="{{ route('admin.kyc.reject', $kyc) }}" class="flex flex-col gap-2 sm:flex-row">
                    @csrf
                    <input type="text" name="reason" placeholder="Rejection reason" required
                           class="rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 {{ $inputClasses }}">
                    <button type="submit" class="rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">Reject</button>
                </form>
            </div>
        </section>
    </div>
</x-layouts.admin>
