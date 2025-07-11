@props(['name', 'label', 'value' => '', 'options' => []])
<div class="mb-3">
    <label class="text-sm">{{ $label }}</label>
    <select name="{{ $name }}" class="input">
        @foreach($options as $key => $text)
            <option value="{{ $key }}" @selected($value == $key)>{{ $text }}</option>
        @endforeach
    </select>
</div>
