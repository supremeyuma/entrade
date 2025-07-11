@props(['name', 'label', 'value' => ''])
<div class="mb-3">
    <label class="text-sm">{{ $label }}</label>
    <input type="text" name="{{ $name }}" value="{{ old($name, $value) }}" class="input">
</div>
