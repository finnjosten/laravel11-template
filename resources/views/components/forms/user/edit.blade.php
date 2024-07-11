<form enctype="multipart/form-data" method="POST" class="form" action="{{ route('dashboard.user.update', $user->id) }}">
    @csrf

    <div class="form__box">
        <div class="col">
            <h3>Name</h3>
            <input required name="name" value="<?= $user->name ?>">
        </div>
        <div class="col">
            <h3>Email</h3>
            <input required name="email" readonly value="<?= $user->email ?>">
        </div>
    </div>
    <div class="form__box">
        <div class="col">
            <h3>Admin</h3>
            <input name="admin"type="checkbox" {{ $user->isAdmin() ? 'checked' : '' }}>
                </div>
        <div class="col">
            <h3>Blocked</h3>
            <input name="blocked" type="checkbox" {{ $user->isBlocked() ? 'checked' : '' }}>
        </div>
    </div>
    <div class="form__box">
        <div class="col">
            <h3>Verified</h3>
            <input name="verified" type="checkbox" {{ $user->isVerified() ? 'checked' : '' }}>
        </div>
    </div>
    <div class="form__box">
        <input type="submit" name="edit" class="btn btn--primary btn--small" value="Save">
    </div>


</form>
