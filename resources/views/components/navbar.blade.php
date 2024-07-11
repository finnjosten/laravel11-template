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

<header>
    <nav class="container">

        <div class="navbar-desktop">
            <a class="navbar-desktop-sitename" href="{{ route('home') }}">
                <h2>{{ vlx_get_env_string('APP_NAME') }}</h2>
            </a>
            <div class="navbar-desktop-items">
                @foreach ($routes as $route)
                    <a href="{{ route($route['name']) }}"><p>{{ $route['show_name'] }}</p></a>
                @endforeach
                @auth
                    @foreach ($auth_routes as $route)
                        <a href="{{ route($route['name']) }}"><p>{{ $route['show_name'] }}</p></a>
                    @endforeach
                @endauth
                @guest
                    @foreach ($guest_routes as $route)
                        <a href="{{ route($route['name']) }}"><p>{{ $route['show_name'] }}</p></a>
                    @endforeach
                @endguest
            </div>
        </div>

        <div class="navbar-mobile">
            <a class="navbar-mobile-sitename" href="{{ route('home') }}">
                <h2>{{ vlx_get_env_string('APP_NAME') }}</h2>
            </a>
            <div class="navbar-mobile-items">
                <div class="open-nav" onclick="openNav()"><i class="da-icon da-icon--bars da-icon--large"></i></div>
            </div>
            <div id="navbar-mobile-fullscreen" class="nav-overlay">
                <p href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="da-icon da-icon--xmark da-icon--xxx-large"></i></p>
                <div class="nav-overlay-content">
                    @foreach ($routes as $route)
                        <a href="{{ route($route['name']) }}"><p>{{ $route['show_name'] }}</p></a>
                    @endforeach
                    @auth
                        @foreach ($auth_routes as $route)
                            <a href="{{ route($route['name']) }}"><p>{{ $route['show_name'] }}</p></a>
                        @endforeach
                    @endauth
                    @guest
                        @foreach ($guest_routes as $route)
                            <a href="{{ route($route['name']) }}"><p>{{ $route['show_name'] }}</p></a>
                        @endforeach
                    @endguest
                </div>
            </div>
        </div>

        <script>
            function openNav() { document.getElementById("navbar-mobile-fullscreen").style.height = "100%"; }
            function closeNav() { document.getElementById("navbar-mobile-fullscreen").style.height = "0%"; }
        </script>
    </nav>
</header>
