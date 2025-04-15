<section class="vlx-block vlx-block--form {{ $class ?? '' }}" {{ isset($id) ? "id='$id'" : '' }}>
    <div class="container {{ $containerClass ?? '' }}">
        @if (isset($title) && !empty($title))
            <div class="vlx-block__header">
                <h2>{{ $title }}</h2>
            </div>
        @endif

        {{ $slot }}
    </div>
</section>
