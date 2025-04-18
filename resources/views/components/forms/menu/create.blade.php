<form method="POST" class="vlx-form" action="{{ route("dashboard.menus.store") }}" id="menuForm">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.input label="Menu name" name="name" type="text" attrs="required" />
        <x-forms.input label="Location" name="location" type="text" attrs="required" desc="Unique identifier for this menu (e.g., 'main', 'footer')" />
    </div>

    <div class="vlx-form__box">
        <x-forms.text-area label="Description" name="description" />
    </div>


    <div class="vlx-form__box">
        <button type="submit" name="update" class="btn btn--success btn--small">
            <x-icon icon="floppy-disk" size="small" />
            Save
        </button>
    </div>

</form>

