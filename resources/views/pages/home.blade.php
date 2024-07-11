@extends('layouts.app')

<!-- Page head -->
@section('head')

<title>Home || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main>
    @include('components.blocks.header-home', ['args' => array(
        'text' => '
        <h1>
            '.env('APP_NAME').'
        </h1>'
    )])
</main>

@endsection
