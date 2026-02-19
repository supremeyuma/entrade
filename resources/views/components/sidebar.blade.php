@php
    $user = auth()->user();
@endphp

<!-- Sidebar -->
<div class="flex items-center justify-between px-4 py-4 border-b border-gray-200 dark:border-gray-700">
    <a href="{{ url('/home') }}" class="text-lg font-bold text-indigo-600 dark:text-indigo-400">Bullsbybit</a>
    <button class="md:hidden text-gray-600 dark:text-gray-300" @click="sidebarOpen = false" aria-label="Close sidebar">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>

<nav class="px-4 py-6 space-y-2 text-gray-700 dark:text-gray-300" x-data="{ 
    tradingMenuOpen: false, 
    accountMenuOpen: false, 
    adminMenuOpen: false,
    faqMenuOpen: false,
    settingsMenuOpen: false,
    kycMenuOpen: false
}">
    {{-- User Links --}}
    @if($user && $user->hasRole('user'))
        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'flex items-center gap-2 px-3 py-2 rounded bg-gray-200 dark:bg-gray-700' : 'flex items-center gap-2 px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('user.deposit.create') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Deposit Funds</a>
        <a href="{{ route('user.withdrawals.create') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Withdraw Funds</a>

        {{-- Trading Dropdown --}}
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                <span class="flex items-center gap-2">Trading</span>
                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div x-show="open" class="ml-4 mt-1 space-y-1">
                <a href="{{ route('user.tradingDashboard') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Trade Dashboard</a>
                <a href="{{ route('user.tradeHistory') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Trade History</a>
                <a href="{{ route('user.leaderboard') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Leaderboard</a>
                <a href="{{ route('user.traders.compare') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Compare Traders</a>
                <a href="{{ route('user.trade.search') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Search Traders</a>
            </div>
        </div>

        {{-- Account Dropdown --}}
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                <span class="flex items-center gap-2">Account</span>
                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div x-show="open" class="ml-4 mt-1 space-y-1">
                <a href="{{ route('user.deposit.history') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Deposit History</a>
                <a href="{{ route('user.transactions.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Transaction History</a>
                <a href="{{ route('user.withdrawals.history') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Withdrawal History</a>
                <a href="{{ route('user.wallets.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Wallets</a>
                <a href="{{ route('user.reports.index', ['trader' => 1]) }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Statements</a>
                <a href="{{ route('user.account.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Account Settings</a>
            </div>
        </div>

        <a href="{{ route('user.referrals.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Referrals</a>
    @endif

    {{-- Admin Links --}}
    @if($user && $user->hasRole('admin'))
        <hr class="border-gray-300 dark:border-gray-600 my-4" />

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'block px-3 py-2 rounded bg-gray-200 dark:bg-gray-700' : 'block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700' }}">Admin Dashboard</a>

        <a href="{{ route('admin.trade-bot.index') }}" class="{{ request()->routeIs('admin.trade-bot.index') ? 'block px-3 py-2 rounded bg-gray-200 dark:bg-gray-700' : 'block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700' }}">Generate Trades</a>

        {{-- Admin Manage Dropdown --}}
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                <span>Manage</span>
                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div x-show="open" class="ml-4 mt-1 space-y-1">
                <a href="{{ route('admin.traders.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Traders</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Users</a>
                <a href="{{ route('admin.trade_logs.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Trade Logs</a>
                <a href="{{ route('admin.trade-outcomes.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Trade Outcomes</a>
                <a href="{{ route('admin.wallets.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">User Wallets</a>
                <a href="{{ route('admin.withdrawals.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Withdrawals</a>
                <a href="{{ route('admin.referrals.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Referrals</a>
                <a href="{{ route('admin.kyc.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">KYC</a>
            </div>
        </div>

        {{-- Trade Manage Dropdown --}}
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                <span>Trades</span>
                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div x-show="open" class="ml-4 mt-1 space-y-1">
                <a href="{{ route('admin.trade-bot.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Generate Trade</a>
                <a href="{{ route('admin.trade-bot.runs.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Bot History</a>
            </div>
        </div>



        {{-- FAQ Management --}}
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
                <span>FAQs</span>
                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div x-show="open" class="ml-4 mt-1 space-y-1">
                <a href="{{ route('admin.faqs.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">FAQ List</a>
                <a href="{{ route('admin.faq-categories.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">FAQ Categories</a>
            </div>
        </div>

        <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Site Settings</a>
        <a href="{{ route('admin.theme.settings') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Theme Settings</a>
        <a href="{{ route('admin.activityLogs') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Activity Logs</a>
    @endif

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">
            Logout
        </button>
    </form>
</nav>
