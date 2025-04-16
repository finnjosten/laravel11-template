
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
    /*
    {#1099 ▼ // resources/views/components/blocks/dynamic/text-image.blade.php
    +"id": "block-1744798756891"
    +"type": "textImage"
    +"template": "text-image"
    +"settings": {#1315 ▼
        +"wst": "large"
        +"wsb": "large"
        +"bg": "normal"
        +"text": "<h2>Lorem Ipsum</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>""
    "
        +"imageUrl": "https://laravel.vacso.cloud/images/example-1.jpg"
        +"imageAlt": ""
        +"buttons": []
    }
    }
  */
@endphp
<section class="{{ $block_classes }}" {{ $id ? "id='$id'" : '' }}>
    <div class="{{ $container_classes }}">
        <div class="vlx-text">
            {!! $text !!}
        </div>
        <div class="vlx-image">
            @if (isset($image))
                <img src="{{ $image->url }}" alt="{{ $image->alt ?? '' }}" class="vlx-image__img">
            @endif
        </div>
    </div>
</section>
