<x-layouts/app>
<div class="min-h-screen flex flex-col">
        <!-- Page Content -->
        <main class="flex-1 md:ml-64">
            {{ $slot }}
        </main>

        @stack('scripts')

    </div>
</x-layouts/app>
