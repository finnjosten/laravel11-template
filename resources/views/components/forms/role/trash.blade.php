<form method="POST" class="vlx-form" action="{{ route('dashboard.user.delete', $user->id) }}">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <label class="h4">Are you sure you want to delete this user?</label>
    </div>

    <div class="vlx-form__box">
        <button type="submit" name="delete" class="btn btn--danger btn--small">
            <x-icon icon="trash" size="small" />
            Delete
        </button>
    </div>

</form>
