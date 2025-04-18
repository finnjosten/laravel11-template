@php
// Only load admin routes if we're in the dashboard
if (Str::contains(request()->url(), vlx_get_env_string('SETTING_ACCOUNT_URL'))) {
    $adminRoutes = [
        "default" => [
            [
                "name" => "Dashboard",
                "link" => route('dashboard.main')
            ],
            [
                "name" => "Profile",
                "link" => route('profile')
            ],
        ],
        "admin" => [
            [
                "name" => "Pages",
                "link" => route('dashboard.pages')
            ],
            [
                "name" => "Menus",
                "link" => route('dashboard.menus')
            ],
            [
                "name" => "Contact",
                "link" => route('dashboard.contact')
            ],
            [
                "name" => "Users",
                "link" => route('dashboard.user')
            ],
        ]
    ];
    $adminRoutes = vlx_cast_to_object($adminRoutes);
}

// Get the main menu
$mainMenu = \App\Models\Menu::where('location', 'main')->first();
@endphp

<header class="vlx-navbar">
    <div class="vlx-navbar__container">
        <a class="vlx-navbar__sitename" href="{{ route('home') }}">
            <h2>{{ vlx_get_env_string('APP_NAME') }}</h2>
        </a>

        <nav class="vlx-navbar__menu">
            @if (isset($adminRoutes))
                {{-- Admin Dashboard Navigation --}}
                @if (isset($adminRoutes->default))
                    @foreach ($adminRoutes->default as $route)
                        <a class="vlx-navbar__link" href="{{ $route->link }}">
                            <p class="vlx-navbar__text">{{ $route->name }}</p>
                        </a>
                    @endforeach
                @endif
                @if (isset($adminRoutes->admin) && auth()->user() && auth()->user()->isAdmin())
                    @foreach ($adminRoutes->admin as $route)
                        <a class="vlx-navbar__link" href="{{ $route->link }}">
                            <p class="vlx-navbar__text">{{ $route->name }}</p>
                        </a>
                    @endforeach
                @endif
            @else
                {{-- Regular Navigation from Menu System --}}
                @if ($mainMenu)
                    @foreach ($mainMenu->items as $item)
                        @if ($item->shouldDisplay())
                            @if ($item->children->count() > 0)
                                <div class="vlx-navbar__dropdown">
                                    <a class="vlx-navbar__link" href="{{ $item->url() }}">
                                        <p class="vlx-navbar__text">{{ $item->title }}</p>
                                    </a>
                                    <div class="vlx-navbar__dropdown-content">
                                        @foreach ($item->children as $child)
                                            @if ($child->shouldDisplay())
                                                <a class="vlx-navbar__link" href="{{ $child->url() }}">
                                                    <p class="vlx-navbar__text">{{ $child->title }}</p>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a class="vlx-navbar__link" href="{{ $item->url() }}">
                                    <p class="vlx-navbar__text">{{ $item->title }}</p>
                                </a>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endif
        </nav>

        <div class="vlx-navbar__toggle">
            <i class="vlx-icon vlx-icon--bars"></i>
        </div>
    </div>
</header>

<script>
    function toggleNav() {
        document.querySelector(".vlx-navbar__menu").classList.toggle("vlx-navbar__menu--open");
    }

    document.querySelector(".vlx-navbar__toggle").addEventListener("click", toggleNav);

    // Close the nav menu when the user clicks outside of it
    document.addEventListener("click", function(event) {
        if (!event.target.closest(".vlx-navbar__container")) {
            document.querySelector(".vlx-navbar__menu").classList.remove("vlx-navbar__menu--open");
        }
    });
</script>
