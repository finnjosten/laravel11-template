<form method="POST" class="vlx-form" action="{{ route('dashboard.user.create') }}">
    @csrf

    <div class="vlx-form__box vlx-form__box">
        <x-forms.input label="UUID" name="uuid" type="text" value="{{ Ramsey\Uuid\Uuid::uuid4()->toString() }}" attrs="required readonly" />
    </div>

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.input label="Name" name="name" type="text" attrs="required" />
        <x-forms.input label="Email" name="email" type="email" attrs="required" />
    </div>

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.switch label="Admin" sublabel="user is an admin" name="admin" />
        <x-forms.switch label="Verified" sublabel="user is verified" name="verified" />
    </div>
    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.switch label="Blocked" sublabel="block user" name="blocked" />
    </div>

    <div class="vlx-form__box">
        <button type="submit" name="update" class="btn btn--success btn--small">
            <x-icon icon="floppy-disk" size="small" />
            Update
        </button>
    </div>

</form>
