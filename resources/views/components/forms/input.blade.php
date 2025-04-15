<div class="vlx-input-box">
    @if (isset($label))
        <label class="h4">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" placeholder="{{ $placeholder ?? "" }}" value="{{ $value ?? "" }}" class="{{ $class ?? "" }}" id="{{ $id ?? "" }}" {{ $attrs ?? "" }}>
</div>
