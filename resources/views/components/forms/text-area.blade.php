<div class="vlx-input-box">
    <label class="h4">{{ $label }}</label>
    <textarea name="{{ $name }}" placeholder="{{ $placeholder ?? "" }}" class="{{ $class ?? "" }}" id="{{ $id ?? "" }}" {{ $attrs ?? "" }}> {{ $value ?? "" }}</textarea>
</div>
