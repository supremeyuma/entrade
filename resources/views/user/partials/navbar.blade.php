<nav class="bg-white shadow rounded-xl px-4 py-3 flex justify-between items-center">
    <div>
        <a href="{{ route('user.dashboard') }}" class="text-lg font-bold text-gray-700 hover:text-blue-500">User Dashboard</a>
    </div>
    <div class="flex items-center space-x-4">
        <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:text-red-800">Logout</button>
        </form>
    </div>
</nav>
