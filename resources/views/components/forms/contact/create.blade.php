<form method="POST" class="form" action="{{ route('contact.add') }}">
    @csrf

    <div class="form__box">
        <div class="col">
            <h3>Email</h3>
            <input required type="email" name="email" placeholder="Your email">
        </div>
        <div class="col">
            <h3>Subject</h3>
            <input required name="subject" placeholder="The subject">
        </div>
    </div>
    <div class="form__box">
        <h3>Message</h3>
        <textarea required name="content" placeholder="The subject"></textarea>
    </div>
    <div class="form__box">
        <input type="submit" name="add" class="btn btn--primary btn--small" value="Save">
    </div>

</form>
