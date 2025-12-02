<form method="POST" class="vlx-form" action="{{ route('dashboard.role.create') }}">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.input label="Name" name="name" type="text" attrs="required" />
        <x-forms.input label="Slug" name="slug" type="slug" attrs="required" />
    </div>

    <div class="vlx-form__box vlx-form__box">
        <x-forms.text-area label="Permissions" name="permissions" attrs="required" />
    </div>

    <div class="vlx-form__box">
        <button type="submit" name="update" class="btn btn--success btn--small">
            <x-icon icon="floppy-disk" size="small" />
            Update
        </button>
    </div>

</form>
