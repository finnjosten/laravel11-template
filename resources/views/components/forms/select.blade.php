@php
    if (isset($selected)) {
        $selected = old($name, $selected);
    } else {
        $selected = old($name, '');
    }
@endphp
<div class="vlx-input-box {{ $topClass ?? "" }}">
    @if (isset($label))
        <label class="vlx-input-box__label h4" for="{{ $name }}">{{ $label }}</label>
    @endif
    <select name="{{ $name }}" id="{{ $id ?? "" }}" class="{{ $class ?? "" }}" {{ $attrs ?? "" }}>
        @foreach ($options as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    @if (isset($desc))
        <p class="vlx-input-box__desc">{{ $desc }}</p>
    @endif
</div>
