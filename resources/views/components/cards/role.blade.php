<div class="vlx-card vlx-card--user js-search-item">
    <div class="vlx-card__header">
        <h3 class="js-searchable">{{ $role->name }}</h3>
    </div>
    <div class="vlx-card__body">
        <p><strong>Slug:</strong> <span class="js-searchable">{{ $role->slug }}</span></p>
        <p><strong>Created at:</strong> {{ $role->created_at->format('d-m-Y') }}</p>
        <p><strong>Last updated:</strong> {{ $role->updated_at->format('d-m-Y') }}</p>

    </div>
    <div class="vlx-card__footer">
        <a href="{{ route('dashboard.role.edit', $role->id) }}" class="btn btn--primary btn--small">
            <x-icon icon="pen-to-square" size="small" />
            Edit
        </a>
    </div>
</div>
