<div class="vlx-input-box {{ $topClass ?? "" }}">
    <label class="vlx-input-box__label h4" for="{{ $name }}">{{ $label }}</label>
    <textarea name="{{ $name }}" placeholder="{{ $placeholder ?? "" }}" class="{{ $class ?? "" }}" id="{{ $id ?? "" }}" {{ $attrs ?? "" }}> {{ $value ?? "" }}</textarea>
    @if (isset($desc))
        <p class="vlx-input-box__desc">{{ $desc }}</p>
    @endif
</div>
