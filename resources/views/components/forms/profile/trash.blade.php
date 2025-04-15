<form method="POST" class="vlx-form" action="{{ route('profile.destroy', auth()->user()->id) }}">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <label class="h4">Are you sure you want to delete your account?</label>
    </div>

    <div class="vlx-form__box">
        <button type="submit" name="delete" class="btn btn--danger btn--small">
            <x-icon name="trash" size="small" />
            Delete
        </button>
    </div>

</form>
