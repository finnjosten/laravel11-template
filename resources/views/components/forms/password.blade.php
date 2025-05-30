<div class="vlx-input-box {{ $topClass ?? "" }}">
    <label class="vlx-input-box__label h4" for="{{ $name }}">{{ $label }}</label>
    <div class="vlx-input-group">
        <input class="js-password" type="password" id="password" name="{{ $name }}" placeholder="{{ $placeholder ?? "" }}" value="{{ $value ?? "" }}" class="{{ $class ?? "" }}" id="{{ $id ?? "" }}" {{ $attrs ?? "" }}>
        <span class="vlx-icon--wrapper">
            <x-icon icon="eye" size="small" class="js-password-btn" />
        </span>
    </div>
    @if (isset($desc))
        <p class="vlx-input-box__desc">{{ $desc }}</p>
    @endif
</div>
