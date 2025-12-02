@php

$mainMenu = [
    [
        "name" => "Home",
        "link" => route('pages.home')
    ],
    [
        "name" => "Profile",
        "link" => route('profile')
    ],
];
$mainMenu = vlxCastToObject($mainMenu);;

// Only load admin routes if we're in the dashboard
if (Str::contains(request()->url(), vlxGetEnvString('SETTING_ACCOUNT_URL'))) {
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
                "name" => "Users",
                "link" => route('dashboard.user')
            ],
            [
                "name" => "Roles",
                "link" => route('dashboard.role')
            ],
            [
                "name" => "Contact",
                "link" => route('dashboard.contact')
            ],
        ]
    ];
    $adminRoutes = vlxCastToObject($adminRoutes);
}
@endphp

<header class="vlx-navbar">
    <div class="vlx-navbar__container">
        <a class="vlx-navbar__sitename" href="{{ route('redirect.home') }}">
            <h2>{{ vlxGetEnvString('APP_NAME') }}</h2>
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
                @if (isset($adminRoutes->admin) && vlxCheckPermission('menu.admin'))
                    @foreach ($adminRoutes->admin as $route)
                        <a class="vlx-navbar__link" href="{{ $route->link }}">
                            <p class="vlx-navbar__text">{{ $route->name }}</p>
                        </a>
                    @endforeach
                @endif
            @else
                {{-- Regular Navigation from Menu System --}}
                @if ($mainMenu && vlxCheckPermission('menu.user'))
                    @foreach ($mainMenu as $item)
                        <a class="vlx-navbar__link" href="{{ $item->link }}">
                            <p class="vlx-navbar__text">{{ $item->name }}</p>
                        </a>
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
