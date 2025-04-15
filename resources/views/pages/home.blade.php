@extends('layouts.app')

<!-- Page head -->
@section('head')

<title>Home || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main>
    <x-blocks.header-home>
        <h1>
            {{ env('APP_NAME') }}
        </h1>
    </x-blocks.header-home>
</main>

@endsection
