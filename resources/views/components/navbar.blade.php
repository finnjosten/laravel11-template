@php
    $routes = [];
    $guest_routes = [];
    $auth_routes = [];

    foreach (Route::getRoutes() as $i => $item) {
        $route['name']      = $item->getName();
        $route['show_name'] = vlx_format_route_name($item->getName());
        $route['namespace'] = $item->action["namespace"] ?? "";

        if($route['namespace'] == 'navbar') {
            $routes[] = $route;
        } elseif ($route['namespace'] == 'guest_navbar') {
            $guest_routes[] = $route;
        } elseif ($route['namespace'] == 'auth_navbar') {
            $auth_routes[] = $route;
        }
    }
@endphp


<header class="vlx-navbar">
    <div class="vlx-navbar__container">

        <a class="vlx-navbar__sitename" href="{{ route('home') }}">
            <h2>{{ vlx_get_env_string('APP_NAME') }}</h2>
        </a>

        <nav class="vlx-navbar__menu">
            @foreach ($routes as $route)
                <a class="vlx-navbar__link" href="{{ route($route['name']) }}">
                    <p class="vlx-navbar__text">{{ $route['show_name'] }}</p>
                </a>
            @endforeach
            @auth
                @foreach ($auth_routes as $route)
                    <a class="vlx-navbar__link" href="{{ route($route['name']) }}">
                        <p class="vlx-navbar__text">{{ $route['show_name'] }}</p>
                    </a>
                @endforeach
            @endauth
            @guest
                @foreach ($guest_routes as $route)
                    <a class="vlx-navbar__link" href="{{ route($route['name']) }}">
                        <p class="vlx-navbar__text">{{ $route['show_name'] }}</p>
                    </a>
                @endforeach
            @endguest
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
