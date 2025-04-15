@extends('layouts.app')

@section('show-nav', 'true')

<!-- Page head -->
@section('head')

<title>Edit profile || {{ env('APP_NAME') }}</title>

<link rel="stylesheet" href="/css/datatables.css?v=1.13.7" />
<script src="/js/datatables.js?v=1.13.7"></script>

@endsection

<!-- Page content -->
@section('content')

<main class="dash profile">
    @include('components.account.sidebar', ['page' => 'profile'])

    <x-blocks.form class="wst--large wsb--medium bg--normal" container-class="container--x-small">
        <div class="vlx-block__header">
            <div class="btn-group btn-group--left">
                <a class="btn btn--warning btn--small" href="{{ route('profile') }}">
                    <x-icon icon="arrow-left" size="small" />
                    Go back
                </a>

                @if($mode == "edit")
                    <a class="btn btn--primary btn--small btn--danger" href="{{ route('profile.trash') }}">
                        <x-icon icon="trash" size="small" />
                        Delete
                    </a>
                @endif
            </div>
        </div>

        @if($mode == 'edit')
            @include('components.forms.profile.edit', ['user' => auth()->user()])
        @elseif($mode == 'delete')
            @include('components.forms.profile.trash')
        @endif
    </x-blocks.form>

</main>

@endsection
