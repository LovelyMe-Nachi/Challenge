@props([
    'label', 
    'name', 
    'type' => 'text', 
    'value' => '', 
    'required' => false
])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
           value="{{ old($name, $value) }}"
           @if($required) required @endif>
    @error($name)
        <p class="error">{{ $message }}</p>
    @enderror
</div>