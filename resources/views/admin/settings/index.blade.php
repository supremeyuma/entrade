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
    @endphp

    <div class="space-y-3 sm:space-y-6 max-w-6xl mx-auto">
        <section data-aos="fade-up" data-aos-delay="0" class="overflow-hidden rounded-[20px] sm:rounded-[28px] border shadow-xl transition duration-500 ease-out hover:-translate-y-1 hover:shadow-2xl {{ $heroClasses }}">
            <div class="relative px-3.5 py-4 sm:px-8 sm:py-8">
                <div class="absolute inset-0 {{ $heroOverlayClasses }}"></div>
                <div class="relative">
                    <p class="text-[11px] font-medium uppercase tracking-[0.18em] sm:tracking-[0.24em] {{ $mutedTextClasses }}">Admin</p>
                    <h1 class="mt-1.5 text-xl font-semibold tracking-tight sm:mt-3 sm:text-4xl {{ $headingClasses }}">Site Settings</h1>
                </div>
            </div>
        </section>

        @if(session('success'))
            <div data-aos="fade-up" data-aos-delay="100" class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-3 sm:space-y-6">
            @csrf

            <div data-aos="fade-up" data-aos-delay="120" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
                <h2 class="mb-4 text-base sm:text-lg font-semibold {{ $headingClasses }}">Referral Settings</h2>

                <x-inputs.toggle name="referral_enabled" label="Enable Referral"
                    :checked="filter_var($settings['referral_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

                <x-inputs.toggle name="referral_bonus_enabled" label="Enable Referral Bonus"
                    :checked="filter_var($settings['referral_bonus_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                    <x-inputs.select name="referral_bonus_type" label="Bonus Type"
                        :value="$settings['referral_bonus_type'] ?? 'flat'"
                        :options="['flat' => 'Flat', 'percentage' => 'Percentage']" />

                    <x-inputs.text name="referral_bonus_amount" label="Bonus Amount"
                        :value="$settings['referral_bonus_amount'] ?? '10'" />

                    <x-inputs.select name="referral_bonus_credit_to" label="Credit Bonus To"
                        :value="$settings['referral_bonus_credit_to'] ?? 'main'"
                        :options="['main' => 'Main', 'trading' => 'Trading']" />
                </div>

                <x-inputs.toggle name="referral_tiered_enabled" label="Enable Tiered Referrals"
                    :checked="filter_var($settings['referral_tiered_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

                <x-inputs.text name="referral_link_expiry_days" label="Referral Link Expiry (days)"
                    :value="$settings['referral_link_expiry_days'] ?? '30'" />

                <x-inputs.select name="referral_payout_mode" label="Referral Payout Mode"
                    :value="$settings['referral_payout_mode'] ?? 'manual'"
                    :options="['manual' => 'Manual', 'approval' => 'Approval', 'auto' => 'Auto']" />
            </div>

            <div data-aos="fade-up" data-aos-delay="150" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
                <h2 class="mb-4 text-base sm:text-lg font-semibold {{ $headingClasses }}">User Report Settings</h2>

                <x-inputs.toggle name="user_reports_enable_deposits" label="Include Deposits"
                    :checked="filter_var($settings['user_reports_enable_deposits'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

                <x-inputs.toggle name="user_reports_enable_withdrawals" label="Include Withdrawals"
                    :checked="filter_var($settings['user_reports_enable_withdrawals'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

                <x-inputs.toggle name="user_reports_enable_trades" label="Include Trades"
                    :checked="filter_var($settings['user_reports_enable_trades'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

                <x-inputs.toggle name="user_reports_enable_referrals" label="Include Referrals"
                    :checked="filter_var($settings['user_reports_enable_referrals'] ?? false, FILTER_VALIDATE_BOOLEAN)" />
            </div>

            <div data-aos="fade-up" data-aos-delay="180" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
                <h2 class="mb-4 text-base sm:text-lg font-semibold {{ $headingClasses }}">Theme & UI</h2>

                <x-inputs.select name="theme.default" label="Default Theme"
                    :value="$settings['theme_default'] ?? 'light'"
                    :options="['light' => 'Light', 'dark' => 'Dark']" />

                <x-inputs.toggle name="theme.allow_user_override" label="Allow Users to Switch Theme"
                    :checked="filter_var($settings['theme_allow_user_override'] ?? false, FILTER_VALIDATE_BOOLEAN)" />
            </div>

            <div data-aos="fade-up" data-aos-delay="210" class="rounded-[20px] sm:rounded-[28px] border p-3.5 sm:p-6 shadow-sm transition duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $surfaceClasses }}">
                <h2 class="mb-4 text-base sm:text-lg font-semibold {{ $headingClasses }}">Deposit/Withdrawal</h2>

                <x-inputs.toggle name="deposits_enabled" label="Enable Deposits"
                    :checked="filter_var($settings['deposits_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN)" />
            </div>

            <button class="rounded-2xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-sky-500 hover:shadow-lg active:scale-[0.99]">Save Settings</button>
        </form>
    </div>
</x-layouts.admin>
