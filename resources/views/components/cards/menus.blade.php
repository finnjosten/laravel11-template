<div class="vlx-card vlx-card--menus js-search-item">
    <div class="vlx-card__header">
        <h3 class="js-searchable">{{ $menu->name }}</h3>
    </div>
    <div class="vlx-card__body">
        <p><strong>Location:</strong> <span class="js-searchable">{{ $menu->location }}</span></p>
        <p><strong>Items:</strong> {{ $menu->allItems()->count() }}</p>
        <p><strong>Created at:</strong> {{ $menu->created_at->format('d-m-Y') }}</p>
        <p><strong>Last updated:</strong> {{ $menu->updated_at->format('d-m-Y') }}</p>

    </div>
    <div class="vlx-card__footer">
        <a href="{{ route('dashboard.menus.edit', $menu->id) }}" class="btn btn--primary btn--small">
            <x-icon icon="pen-to-square" size="small" />
            Edit
        </a>
    </div>
</div>
