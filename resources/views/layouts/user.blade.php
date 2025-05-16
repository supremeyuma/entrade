@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <!--@include('user.partials.navbar')-->
        <main class="mt-4">
            @yield('user-content')
        </main>
    </div>
@endsection
