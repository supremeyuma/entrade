@php
    $user = auth()->user();
@endphp


<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-800 shadow-lg transform transition-transform duration-200 ease-in-out md:translate-x-0"
      :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
      x-show="sidebarOpen"
      @click.away="sidebarOpen = false"
      >
    <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ url('/home') }}" class="text-lg font-bold text-indigo-600 dark:text-indigo-400">Entrade</a>
        <button class="md:hidden text-gray-600 dark:text-gray-300" @click="sidebarOpen = false" aria-label="Close sidebar">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

            <nav class="px-4 py-6 space-y-2 text-gray-700 dark:text-gray-300">
                <a href="{{ url('/user/dashboard') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Dashboard</a>
                <a href="{{ url('/admin/dashboard') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Admin Dashboard</a>
                <a href="{{ url('/admin/traders') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Manage Traders</a>
                <a href="{{ url('/admin/users') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Manage Users</a>
                <a href="{{ url('/admin/settings') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Settings</a>
                <a href="{{ url('/user/profile') }}" class="block px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-indigo-100 dark:hover:bg-indigo-700">Logout</button>
                </form>
            </nav>
        </aside>
