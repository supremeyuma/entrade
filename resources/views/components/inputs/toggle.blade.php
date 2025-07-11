@props(['name', 'label', 'checked' => false])
<div class="flex items-center justify-between mb-3">
    <label for="{{ $name }}" class="text-sm">{{ $label }}</label>
    <input type="hidden" name="{{ $name }}" value="false">
    <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="true"
           class="toggle" @checked($checked)>
</div>
