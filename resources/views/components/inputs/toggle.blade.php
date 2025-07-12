@props(['name', 'label', 'checked' => false])

<div class="flex items-center justify-between mb-3">
    <label for="{{ $name }}" class="text-sm">{{ $label }}</label>

    {{-- Hidden fallback for unchecked boxes --}}
    <input type="hidden" name="{{ $name }}" value="false">

    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $name }}"
        value="true"
        class="form-checkbox h-5 w-5 text-blue-600"
        {{ $checked ? 'checked' : '' }}
    />
</div>
