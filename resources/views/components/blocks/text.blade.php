<section class="vlx-block vlx-block--text {{ $class ?? '' }}" {{ isset($id) ? "id='$id'" : '' }}>
    <div class="container">
        @if (isset($title) && !empty($title))
            <div class="vlx-block__header">
                <h2>{{ $title }}</h2>
            </div>
        @endif
        <div class="vlx-text">
            {{ $slot }}
        </div>
    </div>
</section>
