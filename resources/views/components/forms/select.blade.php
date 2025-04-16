<div class="vlx-input-box">
    @if (isset($label))
        <label class="h4">{{ $label }}</label>
    @endif
    <select name="{{ $name }}" id="{{ $id ?? "" }}" class="{{ $class ?? "" }}">
        @foreach ($options as $value => $label)
            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</div>
