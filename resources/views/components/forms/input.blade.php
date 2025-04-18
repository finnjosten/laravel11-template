<div class="vlx-input-box {{ $topClass ?? "" }}">
    @if (isset($label))
        <label class="vlx-input-box__label h4" for="{{ $name }}">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" placeholder="{{ $placeholder ?? "" }}" value="{{ $value ?? "" }}" class="{{ $class ?? "" }}" id="{{ $id ?? "" }}" {{ $attrs ?? "" }}>
    @if (isset($desc))
        <p class="vlx-input-box__desc">{{ $desc }}</p>
    @endif
</div>
