<x-layouts.admin>
    <div class="max-w-5xl mx-auto py-6 px-4">
        <h1 class="text-2xl font-bold mb-6">Site Settings</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
            @csrf

            {{-- Referral Settings --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h2 class="text-lg font-semibold mb-4">Referral Settings</h2>

                <x-inputs.toggle name="referral_enabled" label="Enable Referral" :checked="($settings['referral_enabled'] ?? 'false') === 'true'" />
                <x-inputs.toggle name="referral_bonus_enabled" label="Enable Referral Bonus" :checked="($settings['referral_bonus_enabled'] ?? 'false') === 'true'" />

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <x-inputs.select name="referral_bonus_type" label="Bonus Type" :value="$settings['referral_bonus_type'] ?? 'flat'" :options="['flat' => 'Flat', 'percentage' => 'Percentage']" />
                    <x-inputs.text name="referral_bonus_amount" label="Bonus Amount" :value="$settings['referral_bonus_amount'] ?? '10'" />
                    <x-inputs.select name="referral_bonus_credit_to" label="Credit Bonus To" :value="$settings['referral_bonus_credit_to'] ?? 'main'" :options="['main' => 'Main', 'trading' => 'Trading']" />
                </div>

                <x-inputs.toggle name="referral_tiered_enabled" label="Enable Tiered Referrals" :checked="($settings['referral_tiered_enabled'] ?? 'false') === 'true'" />
                <x-inputs.text name="referral_link_expiry_days" label="Referral Link Expiry (days)" :value="$settings['referral_link_expiry_days'] ?? '30'" />
                <x-inputs.select name="referral_payout_mode" label="Referral Payout Mode" :value="$settings['referral_payout_mode'] ?? 'manual'" :options="['manual' => 'Manual', 'approval' => 'Approval', 'auto' => 'Auto']" />
            </div>

            {{-- User Reports Settings --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h2 class="text-lg font-semibold mb-4">User Report Settings</h2>
                <x-inputs.toggle name="user_reports_enable_deposits" label="Include Deposits" :checked="($settings['user_reports_enable_deposits'] ?? '1') === '1'" />
                <x-inputs.toggle name="user_reports_enable_withdrawals" label="Include Withdrawals" :checked="($settings['user_reports_enable_withdrawals'] ?? '1') === '1'" />
                <x-inputs.toggle name="user_reports_enable_trades" label="Include Trades" :checked="($settings['user_reports_enable_trades'] ?? '1') === '1'" />
                <x-inputs.toggle name="user_reports_enable_referrals" label="Include Referrals" :checked="($settings['user_reports_enable_referrals'] ?? '1') === '1'" />
            </div>

            {{-- UI & Theme --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h2 class="text-lg font-semibold mb-4">Theme & UI</h2>
                <x-inputs.select name="theme.default" label="Default Theme" :value="$settings['theme.default'] ?? 'light'" :options="['light' => 'Light', 'dark' => 'Dark']" />
                <x-inputs.toggle name="theme.allow_user_override" label="Allow Users to Switch Theme" :checked="($settings['theme.allow_user_override'] ?? 'true') === 'true'" />
            </div>

            {{-- Deposit/Withdrawal --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h2 class="text-lg font-semibold mb-4">Deposit/Withdrawal</h2>
                <x-inputs.toggle name="deposits_enabled" label="Enable Deposits" :checked="($settings['deposits_enabled'] ?? '0') === '1'" />
            </div>

            <button class="btn btn-primary">Save Settings</button>
        </form>
    </div>
</x-layouts.admin>
