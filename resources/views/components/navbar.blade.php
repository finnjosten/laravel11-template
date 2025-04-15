@php
$routes = [
    "default" => [
        [
            "name" => "Home",
            "link" => route('home')
        ],
        [
            "name" => "About",
            "link" => route('about')
        ],
        [
            "name" => "Contact",
            "link" => route('contact')
        ],
    ],
    "guest" => [
        [
            "name" => "Login",
            "link" => route('login')
        ],
    ],
    "auth" => [
        [
            "name" => "Dashboard",
            "link" => route('dashboard.main')
        ]
    ]
];

// If current window is in on the dashboard set other routes
if (Str::contains(request()->url(), vlx_get_env_string('SETTING_ACCOUNT_URL'))) {
    $routes = [
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
                "name" => "Contact",
                "link" => route('dashboard.contact')
            ],
            [
                "name" => "Users",
                "link" => route('dashboard.user')
            ],
        ]
    ];
}

$routes = vlx_cast_to_object($routes);
@endphp


<header class="vlx-navbar">
    <div class="vlx-navbar__container">

        <a class="vlx-navbar__sitename" href="{{ route('home') }}">
            <h2>{{ vlx_get_env_string('APP_NAME') }}</h2>
        </a>

        <nav class="vlx-navbar__menu">
            @if (isset($routes->default))
                @foreach ($routes->default as $route)
                    <a class="vlx-navbar__link" href="{{ $route->link }}">
                        <p class="vlx-navbar__text">{{ $route->name }}</p>
                    </a>
                @endforeach
            @endif
            @if (isset($routes->auth))
                @auth
                    @foreach ($routes->auth as $route)
                        <a class="vlx-navbar__link" href="{{ $route->link }}">
                            <p class="vlx-navbar__text">{{ $route->name }}</p>
                        </a>
                    @endforeach
                @endauth
            @endif
            @if (isset($routes->guest))
                @guest
                    @foreach ($routes->guest as $route)
                        <a class="vlx-navbar__link" href="{{ $route->link }}">
                            <p class="vlx-navbar__text">{{ $route->name }}</p>
                        </a>
                    @endforeach
                @endguest
            @endif
            @if (isset($routes->admin) && auth()->user() && auth()->user()->isAdmin())
                @foreach ($routes->admin as $route)
                    <a class="vlx-navbar__link" href="{{ $route->link }}">
                        <p class="vlx-navbar__text">{{ $route->name }}</p>
                    </a>
                @endforeach
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
