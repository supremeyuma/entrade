<x-layouts.app>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8" x-data="withdrawalForm()">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Withdraw Funds</h2>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 p-4 rounded">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-800 p-4 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Withdrawal Form --}}
        <form action="{{ route('user.withdrawals.store') }}" method="POST" class="space-y-5 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            @csrf

            {{-- Cryptocurrency --}}
            <div>
                <label class="block font-medium mb-1">Cryptocurrency <span class="text-red-500">*</span></label>
                <select name="cryptocurrency" x-model="form.cryptocurrency" @change="updateFee()" required
                        class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="">Select</option>
                    @foreach ($wallets->pluck('cryptocurrency')->unique() as $crypto)
                        <option value="{{ $crypto }}">{{ $crypto }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Wallet --}}
            <div>
                <label class="block font-medium mb-1">Withdraw To <span class="text-red-500">*</span></label>
                <select x-model="form.wallet_address" name="wallet_address"
                        class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="">Select saved wallet</option>
                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->wallet_address }}">
                            {{ $wallet->label ?? $wallet->cryptocurrency . ' wallet' }} — {{ $wallet->wallet_address }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Network (Optional) --}}
            <div>
                <label class="block font-medium mb-1">Network</label>
                <input type="text" name="network" x-model="form.network"
                       class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
            </div>

            {{-- Amount --}}
            <div>
                <label class="block font-medium mb-1">Amount <span class="text-red-500">*</span></label>
                <input type="number" name="amount" x-model.number="form.amount" @input="updateFee()" min="0"
                       class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
            </div>

            {{-- Fee & Net Preview --}}
            <template x-if="form.cryptocurrency && form.amount > 0">
                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded text-sm text-gray-700 dark:text-gray-100 space-y-1">
                    <div>Fee: <span x-text="feeDisplay"></span></div>
                    <div>Net Amount: <span x-text="netAmountDisplay"></span></div>
                </div>
            </template>

            {{-- 2FA --}}
            @if (auth()->user()->two_factor_secret)
            <div>
                <label>2FA Code</label>
                <input type="text" name="code" class="w-full rounded border-gray-300" required>
            </div>
            @endif

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Submit Withdrawal
                </button>
            </div>
        </form>

        {{-- Withdrawal History --}}
        <div class="mt-10">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Withdrawal History</h3>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                        <tr>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Crypto</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">To</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($withdrawals as $withdrawal)
                            <tr>
                                <td class="px-4 py-2">{{ $withdrawal->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2">{{ $withdrawal->cryptocurrency }}</td>
                                <td class="px-4 py-2">{{ $withdrawal->amount }}</td>
                                <td class="px-4 py-2 truncate">{{ $withdrawal->wallet_address }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        @class([
                                            'bg-yellow-100 text-yellow-800' => $withdrawal->status === 'pending',
                                            'bg-green-100 text-green-800' => $withdrawal->status === 'completed',
                                            'bg-red-100 text-red-800' => $withdrawal->status === 'rejected',
                                            'bg-blue-100 text-blue-800' => $withdrawal->status === 'approved',
                                        ])
                                    ">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">No withdrawals yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Alpine.js Withdrawal Logic --}}
    <script>
        function withdrawalForm() {
            return {
                form: {
                    cryptocurrency: '',
                    amount: 0,
                    wallet_address: '',
                    network: '',
                },
                feeSettings: @json($feeSettings ?? []), // from backend
                get fee() {
                    let s = this.feeSettings[this.form.cryptocurrency] || { fixed: 0, percent: 0 };
                    let amount = this.form.amount || 0;
                    return (s.fixed || 0) + (s.percent ? (s.percent / 100) * amount : 0);
                },
                get feeDisplay() {
                    return this.fee.toFixed(8);
                },
                get netAmountDisplay() {
                    return (this.form.amount - this.fee).toFixed(8);
                },
                updateFee() {
                    // triggers reactive Alpine updates
                }
            }
        }
    </script>
</x-layouts.app>
