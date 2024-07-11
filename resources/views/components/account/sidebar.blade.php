<nav>
    <div class="user-group">
        <i class="da-icon da-icon--circle-user"></i>
        <p>{{ auth()->user()->name }}</p>
        <i class="da-icon da-icon--ellipsis-vertical"></i>
        <form class="popup__inner" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="link"><i class="da-icon da-icon--right-from-bracket"></i><p>Logout</p></button>
            <a class="link" href="{{ route('home') }}"><i class="da-icon da-icon--house"></i><p>Home page</p></a>
        </form>
    </div>
    <div class="link-group">
        <a class="link <?php if($page=="dashboard") { echo 'active';} ?>" href="{{ route('dashboard.main') }}">
            <i class="da-icon da-icon--browsers"></i>
            <p>Overview</p>
        </a>
        @if (auth()->user()->isAdmin())
            <a class="link <?php if($page=="contact") { echo 'active';} ?>" href="{{ route('dashboard.contact') }}">
                <i class="da-icon da-icon--envelopes"></i>
                <p>Contact</p>
            </a>
            <a class="link <?php if($page=="user") { echo 'active';} ?>" href="{{ route('dashboard.user') }}">
                <i class="da-icon da-icon--images-user"></i>
                <p>Users</p>
            </a>
        @endif
    </div>
</nav>
