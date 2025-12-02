@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Register || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

@php
    use \Illuminate\Support\Facades\Route;

    $fake_username = fake()->username();
    $fake_username = str_replace([".","#","?"], '', $fake_username);

    $fake_password = fake()->password(8, 20, true, true, true);

    $route_home_exists = Route::has('home');
@endphp

<main class="auth register">
    <section class="vlx-block vlx-block--auth">
        <div class="vlx-container d-flex">

            <form method="post" class="vlx-card vlx-card--auth vlx-card--register" action="{{ route('register.post') }}">
                <div class="vlx-card__body">
                    @csrf
                    {!! RecaptchaV3::field('register') !!}

                    <div class="input-wrapper input-wrapper--email">
                        <label for="email">Email Address</label>
                        <div class="input">
                            <x-icon icon="envelope" />
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="input-wrapper input-wrapper--email">
                        <label for="name">Name</label>
                        <div class="input">
                            <x-icon icon="user" />
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="{{ $fake_username }}" required>
                        </div>
                        <p>Minimum 3 long, letters and - or _</p>
                    </div>
                    <div class="input-wrapper input-wrapper--password">
                        <label for="password">Password</label>
                        <div class="input">
                            <x-icon icon="lock" />
                            <input class="js-password" type="password" name="password" id="password" value="{{ old('password') }}" placeholder="{{ $fake_password }}" required>
                            <x-icon icon="eye" class="js-password-btn" />
                        </div>
                        <p>Minimum 8 long, 1 number, 1 symbol</p>
                    </div>
                    <div class="input-wrapper input-wrapper--password">
                        <label for="password_confirmation">Confirm password</label>
                        <div class="input">
                            <x-icon icon="lock" />
                            <input class="js-password" type="password" name="password_confirmation" id="password_confirmation" required>
                            <x-icon icon="eye" class="js-password-btn" />
                        </div>
                        <p>Enter the password again</p>
                    </div>
                </div>

                <div class="vlx-card__footer">
                    <div class="btn-group btn-group--vert">
                        <button class="btn btn--primary">Sign up</button>
                        <a class="btn btn--secondary" href="{{ route('login') }}">Login</a>
                    </div>
                    <div class="vlx-btn-bar">
                        @if(env('SETTING_CAN_RESET_PASSWORD')) <a href="{{ route('password.request') }}">Forgot password</a> @endif
                        <a href="{{ route('redirect.home') }}">Home</a>
                    </div>
                </div>

                <script>
                </script>
            </form>

        </div>
    </section>

</main>

@endsection
