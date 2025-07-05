{{-- resources/views/user/accounts.blade.php --}}
<x-layouts.app>
    <div class="container mx-auto px-4 py-8" x-data="{ tab: 'profile' }">
        <h1 class="text-2xl font-bold mb-6">Account Settings</h1>

        <!-- Tabs -->
        <nav class="mb-6 flex flex-wrap gap-4 text-sm font-medium border-b pb-2">
            <button @click="tab = 'profile'" :class="tab === 'profile' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2">Profile</button>
            <button @click="tab = 'security'" :class="tab === 'security' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2">Security</button>
            <button @click="tab = 'wallets'" :class="tab === 'wallets' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2">Wallets</button>
            <button @click="tab = 'verification'" :class="tab === 'verification' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2">Verification</button>
            <button @click="tab = 'preferences'" :class="tab === 'preferences' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2">Preferences</button>
            <button @click="tab = 'activity'" :class="tab === 'activity' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2">Activity Log</button>
            <button @click="tab = 'danger'" :class="tab === 'danger' ? 'border-b-2 border-red-600 text-red-600' : 'text-gray-600'" class="pb-2">Danger Zone</button>
        </nav>

        <!-- Sections -->
        <div x-show="tab === 'profile'">
            @include('user.account-sections.profile')
        </div>
        <div x-show="tab === 'security'">
            @include('user.account-sections.security')
        </div>
        <div x-show="tab === 'wallets'">
            @include('user.account-sections.wallets')
        </div>
        <div x-show="tab === 'verification'">
            @include('user.account-sections.verification')
        </div>
        <div x-show="tab === 'preferences'">
            @include('user.account-sections.preferences')
        </div>
        <div x-show="tab === 'activity'">
            @include('user.account-sections.activity-log')
        </div>
        <div x-show="tab === 'danger'">
            @include('user.account-sections.danger-zone')
        </div>
    </div>
</x-layouts.app>
