@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Dashboard || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')


    <main class="page page--account dashboard">
        @include('components.account.sidebar', ['page' => 'dashboard'])
        <div class="content">
            <section class="row">
                <div class="col col--1 bg--light"> </div>
                <div class="col col--2 bg--light"> </div>
                <div class="col col--3 bg--light"> </div>
                <div class="col col--4 bg--light"> </div>
            </section>

            <section class="row span--2">
                <div class="col col--1 span--2"> </div>
                <div class="col col--2 span--2 bg--accent"> </div>
            </section>

            <section class="row">
                <div class="col col--1 span--2"></div>
                <div class="col col--2 span--2"></div>
            </section>
        </div>
    </main>

@endsection
