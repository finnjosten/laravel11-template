<div class="vlx-input-box {{ $topClass ?? "" }}">
    @if (isset($label))
    <label class="vlx-input-box__label h4" for="{{ $name }}">{{ $label }}</label>
    @endif

    <div class="vlx-input-group">
        <label class="vlx-switch">
            <input class="vlx-switch__input" type="checkbox" name="{{ $name }}" {{ isset($checked) && $checked ? "checked" : "" }} {{ $attrs ?? "" }}>
            <span class="vlx-switch__slider"></span>
        </label>
        @if (isset($sublabel))
            <label for="{{ $name }}" class="vlx-switch__label">
                {{ $sublabel }}
            </label>
        @endif
    </div>
</div>
