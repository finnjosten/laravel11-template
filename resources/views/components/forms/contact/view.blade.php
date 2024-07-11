<div class="form">

    <div class="form__box">
        <div class="col">
            <h3>Email</h3>
            <input required type="email" readonly value="{{ $contact->email }}">
        </div>
        <div class="col">
            <h3>Subject</h3>
            <input required readonly value="{{ $contact->subject }}">
        </div>
    </div>
    <div class="form__box">
        <h3>Message</h3>
        <textarea required readonly>{{ $contact->content }}</textarea>
    </div>

</div>
