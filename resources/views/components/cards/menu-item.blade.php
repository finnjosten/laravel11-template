
<a href="{{ route('menu.single', $item->slug) }}" class="vlx-card vlx-card--items">
    <div class="vlx-card__header">
        @if($item->getFirstMediaUrl())
            <img src="{{ $item->getFirstMediaUrl() }}">
        @else
            <img src="https://picsum.photos/300/200">
        @endif
    </div>
    <div class="vlx-card__body">
        <h3>{{ $item->title }}</h3>
        <p>{{ $item->excerpt }}</p>
    </div>
    <div class="vlx-card__footer">
        <p class="btn btn--primary">Bekijk product</p>
    </div>
</a>
