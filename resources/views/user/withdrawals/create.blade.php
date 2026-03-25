<x-layouts.app>
  <div class="max-w-4xl mx-auto px-4 py-6 sm:px-6 sm:py-10 lg:px-8" x-data="withdrawalForm()">
    <h2 class="mb-4 text-xl font-bold text-gray-800 dark:text-white sm:mb-6 sm:text-2xl">Withdraw Funds</h2>

    {{-- Flash success --}}
    @if (session('success'))
      <div class="mb-4 bg-green-100 text-green-800 p-4 rounded">{{ session('success') }}</div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
      <div class="mb-4 bg-red-100 text-red-800 p-4 rounded">
        <ul class="list-disc ml-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('user.withdrawals.store') }}" method="POST" class="space-y-4 bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:space-y-5 sm:p-6">
      @csrf

      {{-- Saved wallet selector --}}
      <div>
        <label class="block font-medium mb-1">Withdraw From Saved Wallet</label>
        <select x-model="form.wallet_address" @change="onWalletChange()" name="wallet_address"
                class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
          <option value="">— Select saved wallet —</option>
          @foreach ($wallets as $wallet)
            <option value="{{ $wallet->wallet_address }}">
              {{ $wallet->label ?? ($wallet->cryptocurrency . ' wallet') }}
              — ({{ $wallet->cryptocurrency }} / {{ $wallet->network }})
            </option>
          @endforeach
        </select>
      </div>

      {{-- Cryptocurrency select --}}
      <div>
        <label class="block font-medium mb-1">Cryptocurrency <span class="text-red-500">*</span></label>
        <select name="cryptocurrency" x-model="form.cryptocurrency" @change="onCryptoChange()"
                :disabled="isWalletSelected"
                class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                required>
          <option value="">Select crypto / token</option>
          @foreach ($feeSettings as $crypto => $_)
            <option value="{{ $crypto }}">{{ $crypto }}</option>
          @endforeach
        </select>
      </div>

      {{-- Network select --}}
      <div>
        <label class="block font-medium mb-1">Network <span class="text-gray-500">(chain)</span></label>
        <select name="network" x-model="form.network"
                :disabled="isWalletSelected"
                class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
          <option value="">Select network</option>
          <template x-for="net in networkOptions()" :key="net">
            <option :value="net" x-text="net"></option>
          </template>
        </select>
      </div>

      {{-- Amount input --}}
      <div>
        <label class="block font-medium mb-1">Amount <span class="text-red-500">*</span></label>
        <input type="number" name="amount" x-model.number="form.amount" @input="updateFee()"
               min="0" step="0.00000001"
               class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
      </div>

      {{-- Fee & net preview --}}
      <template x-if="form.cryptocurrency && form.amount > 0">
        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded text-sm text-gray-700 dark:text-gray-100 space-y-1">
          <div>Fee: <span x-text="feeDisplay"></span></div>
          <div>Net Amount: <span x-text="netAmountDisplay"></span></div>
        </div>
      </template>

      {{-- 2FA code --}}
      @if (auth()->user()->two_factor_secret)
        <div>
          <label class="block font-medium mb-1">2FA Code</label>
          <input type="text" name="code"
                 class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                 required>
        </div>
      @endif

      <div class="flex justify-end">
        <button type="submit"
                class="w-full rounded bg-blue-600 px-4 py-2 text-sm text-white transition hover:bg-blue-700 sm:w-auto">
          Submit Withdrawal
        </button>
      </div>
    </form>
  </div>

  <script>
    function withdrawalForm() {
      return {
        form: {
          wallet_address: '',
          cryptocurrency: '',
          network: '',
          amount: 0,
        },
        feeSettings: @json($feeSettings),
        walletInfo: @json($walletInfo),
        cryptoNetworks: @json($cryptoNetworks),

        get isWalletSelected() {
          return this.form.wallet_address !== '';
        },

        onWalletChange() {
          if (! this.form.wallet_address) {
            // cleared selection
            this.form.cryptocurrency = '';
            this.form.network = '';
            return;
          }
          let info = this.walletInfo[this.form.wallet_address];
          if (info) {
            this.form.cryptocurrency = info.cryptocurrency;
            this.form.network = info.network;
          }
        },

        onCryptoChange() {
          // when user manually picks crypto, reset network
          this.form.network = '';
        },

        networkOptions() {
          let crypto = this.form.cryptocurrency;
          if (!crypto) return [];
          return this.cryptoNetworks[crypto] || [];
        },

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
          // no manual logic needed — reactive getters update
        }
      };
    }
  </script>
</x-layouts.app>
