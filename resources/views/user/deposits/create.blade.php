@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $inputClasses = $isDark
        ? 'border-slate-700 bg-slate-800 text-slate-100 placeholder:text-slate-500 focus:border-emerald-400 focus:ring-emerald-500/20'
        : 'border-slate-200 bg-slate-50 text-slate-900 placeholder:text-slate-400 focus:border-emerald-400 focus:ring-emerald-200';
@endphp

<x-layouts.app>
    <div class="mx-auto max-w-3xl px-4 py-6 sm:py-8">
        <div class="space-y-4 sm:space-y-6">
            <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                    <div class="pointer-events-none absolute -right-10 top-6 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl animate-pulse"></div>
                    <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Funding</p>
                    <h2 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Make a Deposit</h2>
                    <p class="mt-2 text-sm {{ $isDark ? 'text-slate-300' : 'text-slate-600' }}">Add funds to your account and continue to the payment invoice.</p>
                </div>
            </section>

            <section data-aos="fade-up" data-aos-delay="120" class="rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:p-6 {{ $surfaceClasses }}">
                @if(session('error'))
                    <div data-aos="fade-up" data-aos-delay="200" class="mb-4 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">{{ session('error') }}</div>
                @endif

                <form id="deposit-form" action="{{ route('user.deposit.store') }}" method="POST" class="space-y-4 sm:space-y-5">
                    @csrf
                    <div>
                        <label class="mb-1 block text-sm font-medium {{ $isDark ? 'text-slate-200' : 'text-slate-700' }}">Amount (USD)</label>
                        <input type="number" name="amount" min="10" step="0.01" class="w-full rounded-2xl border px-3 py-2 text-sm transition focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}" required>
                    </div>

                    <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
                        Continue to Payment
                    </button>
                </form>
            </section>
        </div>
    </div>

    <script>
        document.getElementById('deposit-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            let res = await fetch("{{ route('user.deposit.create') }}", {
                method: "POST",
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            let data = await res.json();

            if (data.invoice_url) {
                window.open(data.invoice_url, "_blank");
                window.location.href = "{{ route('user.deposit.history') }}";
            }
        });
    </script>
</x-layouts.app>
