@extends('layouts.app')

<!-- Page head -->
@section('head')

<title>Over ons || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main>
    @include('components.blocks.header-subpage', ['args' => array(
        'text' => '
        <h1>
            Over ons
        </h1>'
    )])
    @include('components.blocks.text', ['args' => array(
        'text' => "
        <h2>Wie zijn wij?</h2>
        <p>
            Lorem ipsum!!
        </p>"
    )])
</main>

@endsection
