@php
    $parent = $page->parent_id ?? null;
    if ($parent) {
        $parent = App\Models\Page::find($parent);
    }
@endphp
<div class="vlx-card vlx-card--pages js-search-item">
    <div class="vlx-card__header">
        <h3 class="js-searchable">{{ $page->title }}</h3>
    </div>
    <div class="vlx-card__body">
        <p><strong>Slug:</strong> <span class="js-searchable">{{ $page->slug }}</span></p>
        <p><strong>Status:</strong> {{ $page->status }}</p>
        <p><strong>Parent:</strong> {{ $parent ? $parent->title : "None" }}</p>
        <p><strong>Created at:</strong> {{ $page->created_at->format('d-m-Y') }}</p>
        <p><strong>Last updated:</strong> {{ $page->updated_at->format('d-m-Y') }}</p>

    </div>
    <div class="vlx-card__footer">
        <a href="{{ route('dashboard.pages.edit', $page->id) }}" class="btn btn--primary btn--small">
            <x-icon icon="pen-to-square" size="small" />
            Edit
        </a>
    </div>
</div>
