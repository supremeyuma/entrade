@props(['type' => 'primary'])

@php
    $variants = [
        'primary' => 'bg-primary text-white hover:bg-primary-dark',
        'secondary' => 'bg-secondary text-white hover:bg-gray-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
    ];
@endphp

<button {{ $attributes->merge(['class' => 'px-4 py-2 rounded shadow '.$variants[$type]]) }}>
    {{ $slot }}
</button>