<div class="vlx-form">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.input label="Email" name="email" placeholder="Your email" type="email" value="{{ $contact->email }}" attrs="required readonly" />
        <x-forms.input label="Subject" name="subject" placeholder="The subject" type="text" value="{{ $contact->subject }}" attrs="required readonly" />
    </div>


    <div class="vlx-form__box">
        <x-forms.text-area label="Message" name="content" value="{{ $contact->content }}" attrs="required readonly" />
    </div>

</div>
