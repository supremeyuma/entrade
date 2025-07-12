@props([
    'name',
    'label' => '',
    'value' => '',
    'rows' => 4,
])

<div>
    @if($label)
        <label for="{{ $name }}" class="block font-medium text-sm text-gray-700 dark:text-gray-200 mb-1">
            {{ $label }}
        </label>
    @endif

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'form-input w-full dark:bg-gray-800 dark:text-white']) }}
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>
