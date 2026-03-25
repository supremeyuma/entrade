@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $subtleSurfaceClasses = $isDark ? 'bg-slate-800/80 text-slate-400' : 'bg-slate-50 text-slate-500';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
    $inputClasses = $isDark
        ? 'border-slate-700 bg-slate-800 text-slate-100 focus:border-emerald-400 focus:ring-emerald-500/20'
        : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-400 focus:ring-emerald-200';
@endphp

<x-layouts.app>
    <div x-data="walletForm()" class="mx-auto max-w-6xl px-4 py-6 sm:py-8">
        <div class="space-y-4 sm:space-y-6">
            <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative px-5 py-6 sm:px-7 sm:py-8">
                    <div class="pointer-events-none absolute -right-10 top-6 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl animate-pulse"></div>
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $isDark ? 'text-slate-400' : 'text-slate-500' }}">Account</p>
                            <h1 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">My Wallets</h1>
                            <p class="mt-2 text-sm {{ $bodyTextClasses }}">Manage withdrawal wallets, copy addresses, and open QR codes quickly.</p>
                        </div>
                        <button @click="openModal = true"
                            class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
                            Add Wallet
                        </button>
                    </div>
                </div>
            </section>

            @if(session('success'))
                <div data-aos="fade-up" data-aos-delay="120" class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif

            <div data-aos="fade-up" data-aos-delay="160" class="overflow-visible rounded-[24px] border shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] {{ $surfaceClasses }}">
                <table class="min-w-full text-left text-sm">
                    <thead class="{{ $subtleSurfaceClasses }}">
                        <tr>
                            <th class="px-3 py-3 uppercase sm:px-6">Cryptocurrency</th>
                            <th class="px-3 py-3 uppercase sm:px-6">Wallet Address</th>
                            <th class="px-3 py-3 uppercase sm:px-6">Network</th>
                            <th class="px-3 py-3 uppercase sm:px-6">Label</th>
                            <th class="px-3 py-3 uppercase sm:px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 {{ $bodyTextClasses }}">
                        @forelse($wallets as $wallet)
                            <tr class="transition duration-300 ease-out hover:bg-slate-50 dark:hover:bg-slate-800/70">
                                <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->cryptocurrency }}</td>
                                <td class="relative overflow-visible break-words px-3 py-3 sm:px-6 sm:py-4">
                                    <div class="flex items-center gap-2" x-data="{ copied: false }">
                                        <span x-text="copied ? 'Copied!' : '{{ $wallet->wallet_address }}'" class="max-w-xs truncate"></span>

                                        <button
                                            @click="navigator.clipboard.writeText('{{ $wallet->wallet_address }}').then(() => { copied = true; setTimeout(() => copied = false, 2000); })"
                                            class="text-xs font-medium text-emerald-600 transition hover:text-emerald-500"
                                            title="Copy address"
                                        >
                                            Copy
                                        </button>

                                        <div x-data="{ showQR: false }" class="relative">
                                            <button @click="showQR = !showQR" class="text-xs font-medium text-emerald-600 transition hover:text-emerald-500">QR</button>

                                            <div x-show="showQR" x-transition
                                                class="absolute left-0 top-6 z-30 flex h-28 w-28 items-center justify-center rounded-2xl bg-white p-2 shadow-xl dark:bg-slate-950"
                                                @click.outside="showQR = false"
                                                style="min-width: 7rem; min-height: 7rem;"
                                            >
                                                <img src="{{ route('qr.generate', ['text' => $wallet->wallet_address]) }}" alt="QR Code" class="h-24 w-24" />
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->network ?? '—' }}</td>
                                <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->label ?? '—' }}</td>
                                <td class="px-3 py-3 sm:px-6 sm:py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <button @click='editWallet(@json($wallet))' class="rounded-2xl border px-3 py-2 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-md {{ $surfaceClasses }}">Edit</button>
                                        <form action="{{ route('user.wallets.destroy', $wallet) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="rounded-2xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-3 py-5 text-center text-sm {{ $bodyTextClasses }} sm:px-6">You haven't added any wallets yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="openModal" x-cloak class="fixed inset-0 z-40 flex items-center justify-center bg-black/50 px-4 backdrop-blur-sm">
            <div class="relative w-full max-w-lg rounded-[28px] border p-4 shadow-2xl sm:p-6 {{ $surfaceClasses }}">
                <button @click="resetForm" class="absolute right-4 top-4 text-xl text-slate-400 transition hover:text-rose-500">&times;</button>

                <h2 class="mb-4 text-xl font-semibold text-slate-900 dark:text-slate-100" x-text="editing ? 'Edit Wallet' : 'Add Wallet'"></h2>

                <form :action="editing ? updateUrl : storeUrl" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="editing">
                        <input type="hidden" name="_method" value="PUT" />
                    </template>

                    <div>
                        <label class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Cryptocurrency <span class="text-rose-500">*</span></label>
                        <select name="cryptocurrency" x-model="form.cryptocurrency"
                                class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}">
                            <option value="">Select crypto / token</option>
                            @foreach ($feeSettings as $crypto => $_)
                                <option value="{{ $crypto }}">{{ $crypto }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Wallet Address <span class="text-rose-500">*</span></label>
                        <input type="text" name="wallet_address" x-model="form.wallet_address"
                               class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}"
                               required />
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Network</label>
                        <select name="network" x-model="form.network"
                                class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}">
                            <option value="">Select network</option>
                            <template x-for="net in networkOptions()" :key="net">
                                <option :value="net" x-text="net"></option>
                            </template>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Label</label>
                        <input type="text" name="label" x-model="form.label"
                               class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}" />
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="resetForm"
                                class="rounded-2xl border px-4 py-2 text-sm font-semibold transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-md {{ $surfaceClasses }}">
                            Cancel
                        </button>
                        <button type="submit"
                                class="rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99]"
                                x-text="editing ? 'Update' : 'Save'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function walletForm() {
            return {
                openModal: false,
                editing: false,
                form: {
                    id: null,
                    cryptocurrency: '',
                    wallet_address: '',
                    network: '',
                    label: '',
                },
                storeUrl: '{{ route('user.wallets.store') }}',
                updateUrl: '',
                cryptoNetworks: @json($cryptoNetworks),

                resetForm() {
                    this.editing = false;
                    this.form = {
                        id: null,
                        cryptocurrency: '',
                        wallet_address: '',
                        network: '',
                        label: '',
                    };
                    this.openModal = false;
                },

                editWallet(wallet) {
                    this.form = { ...wallet };
                    this.editing = true;
                    this.updateUrl = `/user/wallets/${wallet.id}`;
                    this.openModal = true;
                },

                networkOptions() {
                    let crypto = this.form.cryptocurrency;
                    if (!crypto) return [];
                    return this.cryptoNetworks[crypto] || [];
                }
            };
        }
    </script>
</x-layouts.app>
