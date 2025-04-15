@extends('layouts.app')

<!-- Page head -->
@section('head')

<title>Contact || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main>
    <x-blocks.header-subpage>
        <h1>Contact</h1>
    </x-blocks.header-subpage>
    <x-blocks.form class="wst--medium wsb--medium" container-class="container--x-small">
        @include('components.forms.contact.create')
    </x-blocks.form>
</main>

@endsection
