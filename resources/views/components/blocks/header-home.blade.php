<section class="vlx-header vlx-header--home {{ $class ?? '' }}" {{ isset($id) ? "id='$id'" : '' }}>
    <div class="container">
        <div class="vlx-text">
            {{ $slot }}
        </div>
    </div>
</section>
