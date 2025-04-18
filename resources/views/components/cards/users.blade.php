<div class="vlx-card vlx-card--user js-search-item">
    <div class="vlx-card__header">
        <h3 class="js-searchable">{{ $user->name }}</h3>
    </div>
    <div class="vlx-card__body">
        <p><strong>Admin:</strong> {{ $user->isAdmin() ? "Yes" : "No" }}</p>
        <p><strong>Verified:</strong> {{ $user->isVerified() ? "Yes" : "No" }}</p>
        <p><strong>Blocked:</strong> {{ $user->isBlocked() ? "Yes" : "No" }}</p>
        <p><strong>Created at:</strong> {{ $user->created_at->format('d-m-Y') }}</p>
        <p><strong>Last updated:</strong> {{ $user->updated_at->format('d-m-Y') }}</p>

    </div>
    <div class="vlx-card__footer">
        <a href="{{ route('dashboard.user.edit', $user->id) }}" class="btn btn--primary btn--small">
            <x-icon icon="pen-to-square" size="small" />
            Edit
        </a>
    </div>
</div>
