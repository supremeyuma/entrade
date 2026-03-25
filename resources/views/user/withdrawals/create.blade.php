@php
    $isDark = session('theme') === 'dark';
    $heroClasses = $isDark ? 'border-slate-800 bg-slate-950 text-slate-100 shadow-black/20' : 'border-slate-200 bg-white text-slate-900';
    $heroOverlayClasses = $isDark
        ? 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.16),_transparent_26%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,0.92)_58%,_rgba(30,41,59,0.94))]'
        : 'bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.10),_transparent_30%),radial-gradient(circle_at_85%_20%,_rgba(56,189,248,0.10),_transparent_26%),linear-gradient(135deg,_#ffffff,_#f8fafc_58%,_#eef2ff)]';
    $surfaceClasses = $isDark ? 'border-slate-800 bg-slate-900' : 'border-slate-200 bg-white';
    $bodyTextClasses = $isDark ? 'text-slate-300' : 'text-slate-600';
    $mutedTextClasses = $isDark ? 'text-slate-400' : 'text-slate-500';
    $inputClasses = $isDark
        ? 'border-slate-700 bg-slate-800 text-slate-100 focus:border-emerald-400 focus:ring-emerald-500/20'
        : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-emerald-400 focus:ring-emerald-200';
@endphp

<x-layouts.app>
  <div class="mx-auto max-w-4xl px-4 py-6 sm:py-8" x-data="withdrawalForm()">
    <div class="space-y-4 sm:space-y-6">
      <section data-aos="fade-up" data-aos-delay="0" class="relative overflow-hidden rounded-[24px] border shadow-xl transition duration-300 ease-out hover:-translate-y-1 hover:shadow-2xl sm:rounded-[28px] {{ $heroClasses }}">
        <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
        <div class="relative px-5 py-6 sm:px-7 sm:py-8">
          <div class="pointer-events-none absolute -right-10 top-6 h-24 w-24 rounded-full bg-cyan-400/10 blur-2xl animate-pulse"></div>
          <p class="text-[11px] font-medium uppercase tracking-[0.24em] {{ $mutedTextClasses }}">Funding</p>
          <h2 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Withdraw Funds</h2>
          <p class="mt-2 text-sm {{ $bodyTextClasses }}">Send assets to a saved wallet and review fees before submitting.</p>
        </div>
      </section>

      @if (session('success'))
        <div data-aos="fade-up" data-aos-delay="120" class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">{{ session('success') }}</div>
      @endif

      @if ($errors->any())
        <div data-aos="fade-up" data-aos-delay="140" class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('user.withdrawals.store') }}" method="POST" data-aos="fade-up" data-aos-delay="170" class="space-y-4 rounded-[24px] border p-4 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl sm:rounded-[28px] sm:space-y-5 sm:p-6 {{ $surfaceClasses }}">
        @csrf

        <div>
          <label class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Withdraw From Saved Wallet</label>
          <select x-model="form.wallet_address" @change="onWalletChange()" name="wallet_address"
                  class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}">
            <option value="">Select saved wallet</option>
            @foreach ($wallets as $wallet)
              <option value="{{ $wallet->wallet_address }}">
                {{ $wallet->label ?? ($wallet->cryptocurrency . ' wallet') }}
                - ({{ $wallet->cryptocurrency }} / {{ $wallet->network }})
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Cryptocurrency <span class="text-rose-500">*</span></label>
          <select name="cryptocurrency" x-model="form.cryptocurrency" @change="onCryptoChange()"
                  :disabled="isWalletSelected"
                  class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}"
                  required>
            <option value="">Select crypto / token</option>
            @foreach ($feeSettings as $crypto => $_)
              <option value="{{ $crypto }}">{{ $crypto }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Network <span class="{{ $mutedTextClasses }}">(chain)</span></label>
          <select name="network" x-model="form.network"
                  :disabled="isWalletSelected"
                  class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}">
            <option value="">Select network</option>
            <template x-for="net in networkOptions()" :key="net">
              <option :value="net" x-text="net"></option>
            </template>
          </select>
        </div>

        <div>
          <label class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">Amount <span class="text-rose-500">*</span></label>
          <input type="number" name="amount" x-model.number="form.amount" @input="updateFee()"
                 min="0" step="0.00000001"
                 class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}" required>
        </div>

        <template x-if="form.cryptocurrency && form.amount > 0">
          <div class="rounded-3xl bg-slate-50 p-3 text-sm text-slate-700 dark:bg-slate-800 dark:text-slate-100">
            <div>Fee: <span x-text="feeDisplay"></span></div>
            <div>Net Amount: <span x-text="netAmountDisplay"></span></div>
          </div>
        </template>

        @if (auth()->user()->two_factor_secret)
          <div>
            <label class="mb-1 block text-sm font-medium {{ $bodyTextClasses }}">2FA Code</label>
            <input type="text" name="code"
                   class="w-full rounded-2xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 sm:px-4 sm:py-3 {{ $inputClasses }}"
                   required>
          </div>
        @endif

        <div class="flex justify-end">
          <button type="submit"
                  class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-emerald-500 hover:shadow-lg active:scale-[0.99] sm:w-auto sm:px-5 sm:py-3">
            Submit Withdrawal
          </button>
        </div>
      </form>
    </div>
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
          if (!this.form.wallet_address) {
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
        }
      };
    }
  </script>
</x-layouts.app>
