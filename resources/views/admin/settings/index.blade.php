<x-layouts.admin>
    <div class="max-w-5xl mx-auto py-6 px-4">
        <h1 class="mb-4 text-xl font-bold sm:mb-6 sm:text-2xl">Site Settings</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6 sm:space-y-8">
            @csrf

            {{-- Referral Settings --}}
            <div class="bg-white dark:bg-gray-800 rounded shadow p-4 sm:p-6">
                <h2 class="text-lg font-semibold mb-4">Referral Settings</h2>

                <x-inputs.toggle name="referral_enabled" label="Enable Referral"
                    :checked="filter_var($settings['referral_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

                <x-inputs.toggle name="referral_bonus_enabled" label="Enable Referral Bonus"
                    :checked="filter_var($settings['referral_bonus_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
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

            {{-- User Reports Settings --}}
            <div class="bg-white dark:bg-gray-800 rounded shadow p-4 sm:p-6">
                <h2 class="text-lg font-semibold mb-4">User Report Settings</h2>

                <x-inputs.toggle name="user_reports_enable_deposits" label="Include Deposits"
                    :checked="filter_var($settings['user_reports_enable_deposits'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

                <x-inputs.toggle name="user_reports_enable_withdrawals" label="Include Withdrawals"
                    :checked="filter_var($settings['user_reports_enable_withdrawals'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

                <x-inputs.toggle name="user_reports_enable_trades" label="Include Trades"
                    :checked="filter_var($settings['user_reports_enable_trades'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

                <x-inputs.toggle name="user_reports_enable_referrals" label="Include Referrals"
                    :checked="filter_var($settings['user_reports_enable_referrals'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

            </div>

            {{-- UI & Theme --}}
            <div class="bg-white dark:bg-gray-800 rounded shadow p-4 sm:p-6">
                <h2 class="text-lg font-semibold mb-4">Theme & UI</h2>

                <x-inputs.select name="theme.default" label="Default Theme"
                    :value="$settings['theme_default'] ?? 'light'"
                    :options="['light' => 'Light', 'dark' => 'Dark']" />

                <x-inputs.toggle name="theme.allow_user_override" label="Allow Users to Switch Theme"
                    :checked="filter_var($settings['theme_allow_user_override'] ?? false, FILTER_VALIDATE_BOOLEAN)" />
            </div>

            {{-- Deposit/Withdrawal --}}
            <div class="bg-white dark:bg-gray-800 rounded shadow p-4 sm:p-6">
                <h2 class="text-lg font-semibold mb-4">Deposit/Withdrawal</h2>

                <x-inputs.toggle name="deposits_enabled" label="Enable Deposits"
                    :checked="filter_var($settings['deposits_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN)" />

            </div>

            <button class="btn btn-primary">Save Settings</button>
        </form>
    </div>
</x-layouts.admin>
