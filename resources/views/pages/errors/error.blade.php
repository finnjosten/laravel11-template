@extends('layouts.app')

@section('show-nav', 'false')

@section('head')

<title>{{ $code }} || {{ env('APP_NAME') }}</title>

@endsection

@section('content')

<main>
    <section class="block block--error">
        <div class="container">
            <div class="inner d-grid--center">
                <div class="text">
                    <h1>{{ $code }}</h1>
                    <h2>{{ $message }}</h2>
                    <div class="btn-group">
                        @auth
                            <a href="{{ route('home') }}" class="btn btn--primary">Go home!</a>
                            <a href="{{ route('dashboard.main') }}" class="btn btn--primary">Go to your dashboard!</a>
                        @endauth
                        @guest
                            <a href="{{ route('home') }}" class="btn btn--primary">Go home!</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
