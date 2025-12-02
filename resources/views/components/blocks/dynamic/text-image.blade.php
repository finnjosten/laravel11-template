
@php
    //dd($block);
    $settings = $block->settings;
    $id = $block->id ?? null;
    $image = new \stdClass();

    $block_classes = "vlx-block vlx-block--text-image";
    $block_classes .= $settings->wst ? " wst--{$settings->wst}" : '';
    $block_classes .= $settings->wsb ? " wsb--{$settings->wsb}" : '';
    $block_classes .= $settings->bg ? " bg--{$settings->bg}" : '';

    $container_classes = "container g-32";
    $container_classes .= $settings->split ? " col-split--{$settings->split}" : '';
    $container_classes .= $settings->mediaAlign ? " media-align--{$settings->mediaAlign}" : '';


    $text       = $settings->text ?? '';
    $image->url = $settings->imageUrl ?? '';
    $image->alt = $settings->imageAlt ?? '';
@endphp
<section class="{{ $block_classes }}" {{ $id ? "id='$id'" : '' }}>
    <div class="{{ $container_classes }}">
        <div class="vlx-text">
            {!! vlxReplacePlaceholders($text) !!}
        </div>
        <div class="vlx-image">
            @if (isset($image))
                <img src="{{ $image->url }}" alt="{{ $image->alt ?? '' }}" class="vlx-image__img">
            @endif
        </div>
    </div>
</section>
