<form method="POST" class="vlx-form" action="{{ route('dashboard.user.update', $user->id) }}">
    @csrf
    @php
        use App\Models\Role;
        $roles = Role::all()->pluck('name', 'slug')->toArray();
    @endphp

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.input label="Name" name="name" type="text" value="{{ $user->name }}" attrs="required" />
        <x-forms.input label="Email" name="email" type="email" value="{{ $user->email }}" attrs="required readonly" />
    </div>

    <div class="vlx-form__box vlx-form__box">
        <x-forms.select label="Role" name="role" :options="$roles" :selected="$user->role->slug" attrs="required" />
    </div>

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.switch label="Verified" sublabel="user is verified" name="verified" checked="{{ $user->isVerified() }}" />
        <x-forms.switch label="Blocked" sublabel="block user" name="blocked" checked="{{ $user->isBlocked() }}" />
    </div>

    <div class="vlx-form__box">
        <button type="submit" name="update" class="btn btn--success btn--small">
            <x-icon icon="floppy-disk" size="small" />
            Update
        </button>
    </div>

</form>
