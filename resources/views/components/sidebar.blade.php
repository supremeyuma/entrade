@php
    $user = auth()->user();
@endphp

<aside
    x-data="{ open: false }"
    x-on:toggle-sidebar.window="open = !open"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-800 shadow-lg transform md:translate-x-0 transition-transform duration-200 ease-in-out"
    :class="{ '-translate-x-full': !open, 'translate-x-0': open }"
    @click.away="open = false"
>
    <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('home') }}" class="text-lg font-bold text-indigo-600 dark:text-indigo-400">Entrade</a>
        <button class="md:hidden text-gray-600 dark:text-gray-300" @click="open = false" aria-label="Close sidebar">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>
    </div>

    <nav class="px-4 py-6 space-y-2 text-gray-700 dark:text-gray-300">
        <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
            Dashboard
        </a>

        @if($user->hasRole('admin'))
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                Admin Dashboard
            </a>
            <a href="{{ route('admin.traders.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                Manage Traders
            </a>
            <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                Manage Users
            </a>
            <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                Settings
            </a>
        @endif

        @if($user->hasRole('user'))
            <a href="{{ route('user.tradeHistory') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                Trade History
            </a>
            <a href="{{ route('user.myTraders') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                My Traders
            </a>
            <a href="{{ route('user.referrals.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                Referrals
            </a>
        @endif

        <a href="{{ route('user.profile.show') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
            Profile
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                Logout
            </button>
        </form>
    </nav>
</aside>