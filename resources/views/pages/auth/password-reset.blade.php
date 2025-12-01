@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Reset Password || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

@php
    use \Illuminate\Support\Facades\Route;

    $route_home_exists = Route::has('home');

@endphp

<main class="auth reset-pass">
    <section class="vlx-block vlx-block--auth">
        <div class="vlx-container d-flex">

            <form method="post" class="vlx-card vlx-card--auth vlx-card--reset-pass" action="{{ route('password.reset.post') }}">
                <div class="vlx-card__body">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" id="email" value="{{ $email }}" required>

                    <div class="input-wrapper input-wrapper--password">
                        <label for="password">Password</label>
                        <div class="input">
                            <x-icon icon="lock" />
                            <input class="js-password" type="password" name="password" id="password" required>
                            <x-icon icon="eye" class="js-password-btn" />
                        </div>
                    </div>

                    <div class="input-wrapper input-wrapper--password">
                        <label for="password_confirmation">Confirm password</label>
                        <div class="input">
                            <x-icon icon="lock" />
                            <input class="js-password" type="password" name="password_confirmation" id="password_confirmation" required>
                            <x-icon icon="eye" class="js-password-btn" />
                        </div>
                    </div>
                </div>

                <div class="vlx-card__footer">
                    <div class="btn-group btn-group--vert">
                        <button class="btn btn--primary">Reset password</button>
                    </div>
                    <div class="vlx-btn-bar">
                        <a href="{{ route('login') }}">Login</a>
                    </div>
                </div>
            </form>

        </div>
    </section>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInputs = document.querySelectorAll('.js-password');
        const passwordBtns = document.querySelectorAll('.js-password-btn');

        passwordBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                if (passwordInputs[index].type === 'password') {
                    passwordInputs[index].type = 'text';
                    btn.classList.remove('vlx-icon--eye');
                    btn.classList.add('vlx-icon--eye-slash');
                } else {
                    passwordInputs[index].type = 'password';
                    btn.classList.add('vlx-icon--eye');
                    btn.classList.remove('vlx-icon--eye-slash');
                }
            });
        });
    });
</script>

@endsection
