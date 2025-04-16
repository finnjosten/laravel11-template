@php
    //dd($block);
    $settings = $block->settings;
    $id = $block->id ?? null;

    $block_classes = "vlx-block vlx-block--text";
    $block_classes .= $settings->wst ? " wst--{$settings->wst}" : '';
    $block_classes .= $settings->wsb ? " wsb--{$settings->wsb}" : '';
    $block_classes .= $settings->bg ? " bg--{$settings->bg}" : '';

    $title = $settings->title ?? '';
    $text1 = $settings->text1 ?? '';
    $text2 = $settings->text2 ?? '';

    $both_filled = !empty($text1) && !empty($text2);

    $container_classes = "container";
    if ($both_filled){
        $container_classes .= " d-grid g-32";
        $container_classes .= $settings->split ? " col-split--{$settings->split}" : '';
    }
@endphp
<section class="{{ $block_classes }}" {{ $id ? "id='$id'" : '' }}>
    @if ($title)
        <div class="container vlx-block__header">
            <h2 class="vlx-block__title">{{ $title }}</h2>
        </div>
    @endif
    <div class="{{ $container_classes }}">
        <div class="vlx-text">
            {!! $text1 !!}
        </div>
        <div class="vlx-text">
            {!! $text2 !!}
        </div>
    </div>
</section>
