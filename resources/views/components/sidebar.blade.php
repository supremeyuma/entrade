@php
    $user = auth()->user();
@endphp

<!-- Sidebar -->
    <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ url('/home') }}" class="text-lg font-bold text-indigo-600 dark:text-indigo-400">Entrade</a>
        <button class="md:hidden text-gray-600 dark:text-gray-300" @click="sidebarOpen = false" aria-label="Close sidebar">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <nav class="px-4 py-6 space-y-2 text-gray-700 dark:text-gray-300" x-data="{ userMenuOpen: false, adminMenuOpen: false }">
        {{-- User Links --}}
        @if($user && $user->hasRole('user'))
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('user.deposit.create') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Deposit Funds
            </a>

            <div x-data="{ tradingMenuOpen: false }"> 
                <button @click="tradingMenuOpen = !tradingMenuOpen" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17v-2a4 4 0 014-4h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13 7h6a2 2 0 012 2v10a2 2 0 01-2 2h-6a2 2 0 01-2-2V9a2 2 0 012-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Trading
                    </span>
                    <svg :class="{ 'rotate-180': tradingMenuOpen }" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <div x-show="tradingMenuOpen" class="ml-4 space-y-1">
                    <a href="{{ route('user.tradeHistory') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Trade History</a>
                    <a href="{{ route('user.leaderboard') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Leaderboard</a>
                    
                    <a href="{{ route('user.myTraders') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">My Traders</a>
                    <a href="{{ route('user.trade.search') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Search Traders</a>
                </div>
            </div>

            <div x-data="{ accountMenuOpen: false }"> 
                <button @click="accountMenuOpen = !accountMenuOpen" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17v-2a4 4 0 014-4h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13 7h6a2 2 0 012 2v10a2 2 0 01-2 2h-6a2 2 0 01-2-2V9a2 2 0 012-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Account Records
                    </span>
                    <svg :class="{ 'rotate-180': accountMenuOpen }" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <div x-show="accountMenuOpen" class="ml-4 space-y-1">
                    <a href="{{ route('user.tradeHistory') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Deposit History</a>
                    <a href="{{ route('user.withdrawals.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Withdrawal History</a>
                    <a href="{{ route('user.wallets.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Wallets</a>
                    <a href="{{ route('user.reports.index', ['trader' => 1]) }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Statements</a>
                </div>
            </div>

            <a href="{{ route('user.profile.show') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Accounts</a>
            <a href="{{ route('user.deposit.history') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Deposit History</a>
            <a href="{{ route('user.profile.show') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Profile</a>
        @endif

        {{-- Admin Links --}}
        @if($user && $user->hasRole('admin'))
            <hr class="border-gray-300 dark:border-gray-600 my-4" />

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Admin Dashboard
            </a>

            <div>
                <button @click="adminMenuOpen = !adminMenuOpen" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 10h16M4 14h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Manage
                    </span>
                    <svg :class="{ 'rotate-180': adminMenuOpen }" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <div x-show="adminMenuOpen" class="ml-4 space-y-1">
                    <a href="{{ route('admin.traders.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Traders</a>
                    <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Users</a>
                    <a href="{{ route('admin.trade_logs.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Trade Logs</a>
                    <a href="{{ route('admin.trade-outcomes.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Trade Outcomes</a>
                    <a href="{{ route('admin.referrals.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Referrals</a>
                </div>
            </div>

            <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Settings</a>
        @endif

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                Logout
            </button>
        </form>
    </nav>
