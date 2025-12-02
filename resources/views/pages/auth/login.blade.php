@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Login || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

@php
    use \Illuminate\Support\Facades\Route;
    $route_register_exists = Route::has('register');

@endphp

<main class="auth login">
    <section class="vlx-block vlx-block--auth">
        <div class="vlx-container d-flex">

            <form method="post" class="vlx-card vlx-card--auth vlx-card--login" action="{{ route('login.post') }}">
                <div class="vlx-card__body">
                    @csrf
                    {!! RecaptchaV3::field('login') !!}

                    <div class="input-wrapper input-wrapper--email">
                        <label for="email">Email Address</label>
                        <div class="input">
                            <x-icon icon="envelope" />
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="input-wrapper input-wrapper--password">
                        <label for="password">Password</label>
                        <div class="input">
                            <x-icon icon="lock" />
                            <input class="js-password" type="password" name="password" id="password" required>
                            <x-icon icon="eye" class="js-password-btn" />
                        </div>
                    </div>
                </div>

                <div class="vlx-card__footer">
                    <div class="btn-group btn-group--vert">
                        <button class="btn btn--primary">Login </button>
                        @if(env('SETTING_CAN_REGISTER'))
                            <a class="btn btn--secondary" href="{{ route('register') }}">Sign up</a>
                        @endif
                    </div>
                    <div class="vlx-btn-bar">
                        @if(env('SETTING_CAN_RESET_PASSWORD')) <a href="{{ route('password.request') }}">Forgot password</a> @endif
                        <a href="{{ route('redirect.home') }}">Home</a>
                    </div>
                </div>
            </form>

        </div>
    </section>

</main>

@endsection
