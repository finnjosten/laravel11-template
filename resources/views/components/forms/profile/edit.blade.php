<form method="POST" class="vlx-form" action="{{ route('profile.update') }}">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.input label="Name" name="name" type="text" value="{{ $user->name }}" attrs="required" />
        <x-forms.input label="Email" name="email" type="email" value="{{ $user->email }}" attrs="required" />
    </div>

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.password label="Current password" name="cur_password" />
        <x-forms.password label="New password" name="new_password" />
    </div>


    <div class="vlx-form__box">
        <button type="submit" name="update" class="btn btn--success btn--small">
            <x-icon icon="floppy-disk" size="small" />
            Update
        </button>
    </div>

</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInputs = document.querySelectorAll('.js-password');
        const passwordBtns = document.querySelectorAll('.js-password-btn');

        passwordBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                if (passwordInputs[index].type === 'password') {
                    passwordInputs[index].type = 'text';
                    btn.classList.remove('vlx-icon--eye');
                    btn.classList.add('vlx-icon--eye-slash');
                } else {
                    passwordInputs[index].type = 'password';
                    btn.classList.add('vlx-icon--eye');
                    btn.classList.remove('vlx-icon--eye-slash');
                }
            });
        });
    });
</script>
