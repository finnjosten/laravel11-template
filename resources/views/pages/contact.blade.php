@extends('layouts.app')

<!-- Page head -->
@section('head')

<title>Contact || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main>
    @include('components.blocks.header-subpage', ['args' => array(
        'text' => '
        <h1>
            Contact
        </h1>'
    )])
    <section class="block block--form">
        <div class="container">
            @include('components.forms.contact.create')
        </div>
    </section>
</main>

@endsection
