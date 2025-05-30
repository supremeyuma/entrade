@props(['notifications'])

<div class="relative">
    <button id="notif-toggle" class="relative">
        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor">
            <use xlink:href="#icon-bell"/>
        </svg>
        @if($notifications->where('read', false)->count())
            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
        @endif
    </button>

    <div id="notif-panel" class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded shadow-lg hidden z-50">
        <div class="p-2 max-h-64 overflow-y-auto">
            @forelse($notifications as $note)
                <a href="{{ $note->link }}" class="block px-2 py-1 text-sm border-b hover:bg-gray-100 dark:hover:bg-gray-700 {{ $note->read ? 'text-gray-500' : 'font-semibold text-black dark:text-white' }}">
                    {{ $note->message }}
                </a>
            @empty
                <p class="text-sm text-center text-gray-500">No notifications.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.getElementById('notif-toggle')?.addEventListener('click', () => {
        const panel = document.getElementById('notif-panel');
        panel.classList.toggle('hidden');
    });
</script>