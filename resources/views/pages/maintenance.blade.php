@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Maintenace || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main>
    <section class="block block--header block--header-home">
        <div class="container">
            <div class="text">
                <h1>{{ __('Maintenace mode') }}</h1>
                <h2>{{ !isset($message) || empty($message) ? env('SETTING_MAINTENANCE_MSG') : $message }}</h2>
            </div>
        </div>
    </section>
</main>

@endsection
