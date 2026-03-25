{{-- resources/views/user/accounts.blade.php --}}
<x-layouts.app>
    <div class="container mx-auto px-4 py-6 sm:py-8" x-data="{ tab: 'profile' }">
        <h1 class="mb-4 text-xl font-bold sm:mb-6 sm:text-2xl">Account Settings</h1>

        <!-- Tabs -->
        <nav class="mb-4 flex flex-wrap gap-x-3 gap-y-2 border-b pb-2 text-xs font-medium sm:mb-6 sm:gap-4 sm:text-sm">
            <button @click="tab = 'profile'" :class="tab === 'profile' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2 whitespace-nowrap">Profile</button>
            <button @click="tab = 'security'" :class="tab === 'security' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2 whitespace-nowrap">Security</button>
            <button @click="tab = 'notifications'" :class="tab === 'notifications' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2 whitespace-nowrap">Notifications</button>
            <button @click="tab = 'verification'" :class="tab === 'verification' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2 whitespace-nowrap">Verification</button>
            <button @click="tab = 'preferences'" :class="tab === 'preferences' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2 whitespace-nowrap">Preferences</button>
            <button @click="tab = 'activity'" :class="tab === 'activity' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'" class="pb-2 whitespace-nowrap">Activity Log</button>
            <button @click="tab = 'danger'" :class="tab === 'danger' ? 'border-b-2 border-red-600 text-red-600' : 'text-gray-600'" class="pb-2 whitespace-nowrap">Danger Zone</button>
        </nav>

        <!-- Sections -->
        <div x-show="tab === 'profile'">
            @include('user.account-sections.profile')
        </div>
        <div x-show="tab === 'security'">
            @include('user.account-sections.security')
        </div>
    
        <div x-show="tab === 'verification'">
            @include('user.account-sections.verification')
        </div>
        <div x-show="tab === 'preferences'">
            @include('user.account-sections.preferences')
        </div>
       
        <div x-show="tab === 'notifications'">
            @include('user.account-sections.notifications')
        </div>
        <div x-show="tab === 'activity'">
            @include('user.account-sections.activity-log')
        </div>
        <div x-show="tab === 'danger'">
            @include('user.account-sections.delete-account')
        </div>
    </div>
</x-layouts.app>
