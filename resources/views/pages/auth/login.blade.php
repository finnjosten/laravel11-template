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

            <form
                method="post"
                class="vlx-card vlx-card--auth vlx-card--login"

                @if (!empty(request()->query('return')))
                    action="{{ route('login.post', ["return" => request()->query('return')]) }}"
                @else
                    action="{{ route('login.post') }}"
                @endif
            >
                <div class="vlx-card__header">
                    <img src="{{ env('APP_LOGO') }}" alt="{{ env('APP_NAME') }}" class="logo">
                </div>

                <div class="vlx-card__body">
                    @csrf

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
                    <button class="btn">Login </button>
                    <div class="vlx-btn-bar">
                        @if(env('SETTING_CAN_REGISTER')) <a href="{{ route('register') }}">Sign up</a> @endif
                        @if(env('SETTING_CAN_RESET_PASSWORD')) <a href="{{ route('reset') }}">Forgot password</a> @endif
                    </div>
                </div>
            </form>

        </div>
    </section>

</main>

@endsection
