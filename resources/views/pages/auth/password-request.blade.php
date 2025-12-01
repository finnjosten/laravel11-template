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

            <form method="post" class="vlx-card vlx-card--auth vlx-card--reset-pass" action="{{ route('password.request.post') }}">
                <div class="vlx-card__body">
                    @csrf
                    {!! RecaptchaV3::field('password') !!}

                    <div class="input-wrapper input-wrapper--email">
                        <label for="email">Email Address</label>
                        <div class="input">
                            <i class="vlx-icon vlx-icon--envelope"></i>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                </div>

                <div class="vlx-card__footer">
                    <div class="btn-group btn-group--vert">
                        <button class="btn btn--primary">Send reset link</button>
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
