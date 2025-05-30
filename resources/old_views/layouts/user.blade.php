@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <!--@include('user.partials.navbar')-->
        <main class="mt-4">
        @if (isset($slot))
            {{ $slot }}
        @else
            @yield('user-content')
        @endif
        </main>
    </div>
@endsection
