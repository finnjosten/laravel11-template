<form method="POST" class="vlx-form" action="{{ route("contact.add") }}">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.input label="Email" name="email" placeholder="Your email" type="email" attrs="required" />
        <x-forms.input label="Subject" name="subject" placeholder="The subject" type="text" attrs="required" />
    </div>


    <div class="vlx-form__box">
        <x-forms.text-area label="Message" name="content" placeholder="The subject" attrs="required" />
    </div>


    <div class="vlx-form__box">
        <button type="submit" name="update" class="btn btn--success btn--small">
            <x-icon icon="floppy-disk" size="small" style="solid" />
            Send
        </button>
    </div>

</form>
