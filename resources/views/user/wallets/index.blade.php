<x-layouts.app>
    <div x-data="walletForm()">
        {{-- Main Content --}}
        <div class="max-w-5xl mx-auto px-4 py-6 sm:px-6 sm:py-10 lg:px-8">
            <div class="mb-4 flex flex-col gap-3 sm:mb-6 sm:flex-row sm:items-center sm:justify-between">
                <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100 sm:text-2xl">My Wallets</h1>
                <button @click="openModal = true"
                    class="w-full rounded-lg bg-blue-600 px-4 py-2 text-sm text-white transition duration-200 hover:bg-blue-700 sm:w-auto">
                    Add Wallet
                </button>
            </div>

            @if(session('success'))
                <div class="mb-4 text-green-600 bg-green-100 px-4 py-2 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-visible">
                <table class="min-w-full text-sm text-left relative">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs">
                        <tr>
                            <th class="px-3 py-3 sm:px-6">Cryptocurrency</th>
                            <th class="px-3 py-3 sm:px-6">Wallet Address</th>
                            <th class="px-3 py-3 sm:px-6">Network</th>
                            <th class="px-3 py-3 sm:px-6">Label</th>
                            <th class="px-3 py-3 sm:px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-800 dark:text-gray-100">
                        @forelse($wallets as $wallet)
                            <tr>
                                <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->cryptocurrency }}</td>
                                <td class="px-3 py-3 sm:px-6 sm:py-4 break-words relative overflow-visible">
                                    <div class="flex items-center space-x-2" x-data="{ copied: false }">
                                        <span x-text="copied ? 'Copied!' : '{{ $wallet->wallet_address }}'" class="truncate max-w-xs"></span>

                                        <button
                                            @click="navigator.clipboard.writeText('{{ $wallet->wallet_address }}').then(() => { copied = true; setTimeout(() => copied = false, 2000); })"
                                            class="text-xs text-blue-600 underline hover:text-blue-800"
                                            title="Copy address"
                                        >
                                            Copy
                                        </button>

                                        <div x-data="{ showQR: false }" class="relative">
                                            <button @click="showQR = !showQR" class="text-xs text-blue-600 underline">QR</button>

                                            <div x-show="showQR" x-transition
                                                class="absolute z-30 top-6 left-0 bg-white dark:bg-gray-900 p-2 rounded shadow w-28 h-28 flex items-center justify-center"
                                                @click.outside="showQR = false"
                                                style="min-width: 7rem; min-height: 7rem;"
                                            >
                                                <img src="{{ route('qr.generate', ['text' => $wallet->wallet_address]) }}" alt="QR Code" class="w-24 h-24" />
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->network ?? '—' }}</td>
                                <td class="px-3 py-3 sm:px-6 sm:py-4">{{ $wallet->label ?? '—' }}</td>
                                <td class="px-3 py-3 sm:px-6 sm:py-4 space-x-2">
                                    <button @click="editWallet({{ $wallet }})" class="text-blue-600 hover:underline">Edit</button>
                                    <form action="{{ route('user.wallets.destroy', $wallet) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-3 py-4 text-center text-gray-500 sm:px-6">You haven't added any wallets yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal --}}
        <div x-show="openModal" x-cloak
             class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
            <div class="relative w-full max-w-lg rounded-lg bg-white p-4 shadow-lg dark:bg-gray-900 sm:p-6">
                <button @click="resetForm" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-xl">&times;</button>

                <h2 class="text-xl font-semibold mb-4" x-text="editing ? 'Edit Wallet' : 'Add Wallet'"></h2>

                <form :action="editing ? updateUrl : storeUrl" method="POST">
                    @csrf
                    <template x-if="editing">
                        <input type="hidden" name="_method" value="PUT" />
                    </template>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Cryptocurrency <span class="text-red-500">*</span></label>
                        <select name="cryptocurrency" x-model="form.cryptocurrency"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                <option value="">Select crypto / token</option>
                            @foreach ($feeSettings as $crypto => $_)
                                <option value="{{ $crypto }}">{{ $crypto }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Wallet Address <span class="text-red-500">*</span></label>
                        <input type="text" name="wallet_address" x-model="form.wallet_address"
                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                               required />
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Network</label>
                        <select name="network" x-model="form.network"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            <option value="">Select network</option>
                        <template x-for="net in networkOptions()" :key="net">
                            <option :value="net" x-text="net"></option>
                        </template>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Label</label>
                        <input type="text" name="label" x-model="form.label"
                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white" />
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="resetForm"
                                class="px-4 py-2 rounded bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-100 hover:bg-gray-400">Cancel</button>
                        <button type="submit"
                                class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700"
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
                }

                onCryptoChange() {
                    // when user manually picks crypto, reset network
                    this.form.network = '';
                },

                networkOptions() {
                    let crypto = this.form.cryptocurrency;
                    if (!crypto) return [];
                    return this.cryptoNetworks[crypto] || [];
                    },
                        }
        }
    </script>
</x-layouts.app>
