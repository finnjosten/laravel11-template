@php
    //dd($block);
    $settings = $block->settings;
    $id = $block->id ?? null;

    $block_classes = "vlx-header vlx-header--subpage";

    $text = $settings->text ?? '';
@endphp
<section class="{{ $block_classes }}" {{ $id ? "id='$id'" : '' }}>
    <div class="container">
        <div class="vlx-text">
            {!! vlxReplacePlaceholders($text) !!}
        </div>
    </div>
</section>
