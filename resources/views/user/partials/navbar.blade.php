<nav class="bg-white shadow rounded-xl px-4 py-3 flex justify-between items-center">
    <div>
        <a href="{{ route('user.dashboard') }}" class="text-lg font-bold text-gray-700 hover:text-blue-500">User Dashboard</a>
    </div>
    <!-- Notification Bell -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        🔔 Notifications
        @if(auth()->user()->unreadNotifications->count())
            <span class="badge bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 300px;">
        @forelse(auth()->user()->unreadNotifications as $notification)
            <li>
            <a class="dropdown-item" href="{{ route('user.notifications.redirect', $notification->id) }}">
                {{ $notification->data['trader_name'] }}'s trade: {{ $notification->data['percentage_change'] }}%
            </a>

            </li>
        @empty
            <li><span class="dropdown-item">No new notifications</span></li>
        @endforelse
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-center" href="{{ route('user.notifications') }}">View All</a></li>
    </ul>
</li>


    <div class="flex items-center space-x-4">
        <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:text-red-800">Logout</button>
        </form>
    </div>
</nav>