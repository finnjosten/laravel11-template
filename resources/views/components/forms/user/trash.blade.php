<form method="POST" class="form" action="{{ route('dashboard.user.delete', $user->id) }}">
    @csrf

    <h3>Are you sure you want to delete this item?</h3>
    <input type="submit" name="delete" class="btn btn--danger btn--small" value="Yes, delete it!">

</form>
