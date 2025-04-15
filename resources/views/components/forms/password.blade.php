<div class="vlx-input-box">
    <label class="h4">{{ $label }}</label>
    <div class="vlx-input-group">
        <input class="js-password" type="password" id="password" name="{{ $name }}" placeholder="{{ $placeholder ?? "" }}" value="{{ $value ?? "" }}" class="{{ $class ?? "" }}" id="{{ $id ?? "" }}" {{ $attrs ?? "" }}>
        <span class="vlx-icon--wrapper">
            <x-icon icon="eye" size="small" class="js-password-btn" />
        </span>
    </div>
</div>
