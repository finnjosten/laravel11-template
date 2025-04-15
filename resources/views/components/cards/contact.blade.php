<div class="vlx-card vlx-card--contact js-search-item">
    <div class="vlx-card__header">
        <h3 class="js-searchable">{{ $contact->subject }}</h3>
    </div>
    <div class="vlx-card__body">
        <p><strong>Created at:</strong> {{ $contact->created_at->format('d-m-Y') }}</p>
        <p><strong>Last updated:</strong> {{ $contact->updated_at->format('d-m-Y') }}</p>
        <p><strong>Sender:</strong> <span class="js-searchable">{{ $contact->email }}</span></p>
    </div>
    <div class="vlx-card__footer">
        <a href="{{ route('dashboard.contact.view', $contact->id) }}" class="btn btn--primary btn--small">
            <x-icon icon="eye" size="small" />
            View
        </a>
    </div>
</div>
