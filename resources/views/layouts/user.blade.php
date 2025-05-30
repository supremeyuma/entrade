<x-app-layout>
<div class="container mx-auto mt-8">
        <!--@include('user.partials.navbar')-->
        <main class="mt-4">
        
            {{ $slot }}
        
        </main>
    </div>
</x-app-layout>
