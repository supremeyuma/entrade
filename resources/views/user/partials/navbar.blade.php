<nav class="flex items-center justify-between rounded-[24px] border border-slate-200 bg-white px-4 py-3 shadow-sm transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">
    <div>
        <a href="{{ route('user.dashboard') }}" class="text-base font-semibold text-slate-900 transition hover:text-emerald-600 dark:text-slate-100 dark:hover:text-emerald-400 sm:text-lg">User Dashboard</a>
    </div>

    <div class="flex items-center gap-4">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700 transition duration-300 ease-out hover:-translate-y-0.5 hover:shadow-md dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                <span>Notifications</span>
                @if(auth()->user()->unreadNotifications->count())
                    <span class="rounded-full bg-rose-600 px-2 py-0.5 text-xs font-semibold text-white">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </button>

            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 z-30 mt-2 w-80 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-slate-900" style="display: none;">
                @forelse(auth()->user()->unreadNotifications as $notification)
                    <a class="block rounded-xl px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800" href="{{ route('user.notifications.redirect', $notification->id) }}">
                        {{ $notification->data['trader_name'] }}'s trade: {{ $notification->data['percentage_change'] }}%
                    </a>
                @empty
                    <span class="block rounded-xl px-3 py-2 text-sm text-slate-500 dark:text-slate-400">No new notifications</span>
                @endforelse
                <div class="my-2 border-t border-slate-200 dark:border-slate-700"></div>
                <a class="block rounded-xl px-3 py-2 text-center text-sm font-semibold text-emerald-600 transition hover:bg-emerald-50 dark:text-emerald-400 dark:hover:bg-emerald-500/10" href="{{ route('user.notifications') }}">View All</a>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span class="hidden text-sm text-slate-600 dark:text-slate-300 sm:inline">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-2xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white transition duration-300 ease-out hover:-translate-y-0.5 hover:bg-rose-500 hover:shadow-lg active:scale-[0.99]">Logout</button>
            </form>
        </div>
    </div>
</nav>
