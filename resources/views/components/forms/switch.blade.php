<div class="vlx-input-box">
    @if (isset($label))
        <label class="h4">{{ $label }}</label>
    @endif

    <div class="vlx-input-group">
        <label class="vlx-switch">
            <input class="vlx-switch__input" type="checkbox" name="{{ $name }}" {{ $checked ? "checked" : "" }} {{ $attrs ?? "" }}>
            <span class="vlx-switch__slider"></span>
        </label>
        @if (isset($sublabel))
            <label for="{{ $name }}" class="vlx-switch__label">
                {{ $sublabel }}
            </label>
        @endif
    </div>
</div>
