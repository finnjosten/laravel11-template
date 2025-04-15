<section class="vlx-block vlx-block--text-image {{ $class ?? '' }}" {{ isset($id) ? "id='$id'" : '' }}>
    <div class="container vlx-media-align--{{ $mediaAlign ?? 'left' }} vlx-col-split--{{ $split ?? '50-50' }}">
        <div class="vlx-text">
            {{ $slot }}
        </div>
        <div class="vlx-image">
            @if (isset($image))
                <img src="{{ $image }}" alt="{{ $alt ?? '' }}" class="vlx-image__img">
            @endif
        </div>
    </div>
</section>
