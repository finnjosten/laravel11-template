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
            {!! vlx_replace_placeholders($text) !!}
        </div>
    </div>
</section>
