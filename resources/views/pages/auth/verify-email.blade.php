@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Verify || {{ env('APP_NAME') }}</title>

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

            <div class="vlx-card vlx-card--auth vlx-card--reset-pass">
                <div class="vlx-card__body vlx-text vlx-text--center">
                    <p>Your email address is not verified.</p>
                    <p>If you havent recieved an email (CHECK YOUR SPAM FOLDER!) click the button below to send a new one.</p>
                </div>

                <div class="vlx-card__footer">
                    <form method="post" action="{{ route('verification.send') }}" class="btn-group btn-group--vert">
                        @csrf
                        {!! RecaptchaV3::field('verify') !!}

                        <button class="btn btn--primary">Resend</button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}" class="vlx-btn-bar">
                        @csrf
                        <button class="btn btn--link">logout</button>
                    </form>
                </div>
            </div>

        </div>
    </section>

</main>

@endsection
