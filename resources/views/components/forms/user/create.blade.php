<form method="POST" class="vlx-form" action="{{ route('dashboard.user.create') }}">
    @csrf
    @php
        use App\Models\Role;
        $roles = Role::all()->pluck('name', 'slug')->toArray();
    @endphp

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.input label="Name" name="name" type="text" attrs="required" />
        <x-forms.input label="Email" name="email" type="email" attrs="required" />
    </div>

    <div class="vlx-form__box vlx-form__box">
        <x-forms.select label="Role" name="role" :options="$roles" attrs="required" />
    </div>

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.switch label="Verified" sublabel="user is verified" name="verified" />
        <x-forms.switch label="Blocked" sublabel="block user" name="blocked" />
    </div>

    <div class="vlx-form__box">
        <button type="submit" name="update" class="btn btn--success btn--small">
            <x-icon icon="floppy-disk" size="small" />
            Update
        </button>
    </div>

</form>
