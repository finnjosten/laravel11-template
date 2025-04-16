<form method="POST" class="vlx-form" action="{{ route('dashboard.user.update', $user->id) }}">
    @csrf

    <div class="vlx-form__box vlx-form__box">
        <x-forms.input label="UUID" name="uuid" type="text" value="{{ $user->uuid }}" attrs="required readonly" />
    </div>

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.input label="Name" name="name" type="text" value="{{ $user->name }}" attrs="required" />
        <x-forms.input label="Email" name="email" type="email" value="{{ $user->email }}" attrs="required readonly" />
    </div>

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.switch label="Admin" sublabel="user is an admin" name="admin" checked="{{ $user->isAdmin() }}" />
        <x-forms.switch label="Verified" sublabel="user is verified" name="verified" checked="{{ $user->isVerified() }}" />
    </div>
    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.switch label="Blocked" sublabel="block user" name="blocked" checked="{{ $user->isBlocked() }}" />
    </div>

    <div class="vlx-form__box">
        <button type="submit" name="update" class="btn btn--success btn--small">
            <x-icon icon="floppy-disk" size="small" />
            Update
        </button>
    </div>

</form>
