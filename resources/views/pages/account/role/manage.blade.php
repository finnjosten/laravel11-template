@extends('layouts.app')

@section('show-nav', 'true')

<!-- Page head -->
@section('head')

<title>Edit user || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main class="dash users">
    @include('components.account.sidebar', ['page' => 'user'])

    <x-blocks.form class="wst--large wsb--medium bg--normal" container-class="container--x-small">
        <div class="vlx-block__header">
            <div class="btn-group btn-group--left">
                <a class="btn btn--primary btn--small" href="{{ route('dashboard.user') }}">
                    <x-icon icon="arrow-left" size="small" />
                    Go back
                </a>

                @if($mode == "edit")
                    <a class="btn btn--primary btn--small btn--danger" href="{{ route('dashboard.user.trash', $user->id) }}">
                        <x-icon icon="trash" size="small" />
                        Delete
                    </a>
                @endif
            </div>
        </div>

        @if($mode == 'edit')
            @include('components.forms.user.edit', ['user' => $user])
        @elseif($mode == 'delete')
            @include('components.forms.user.trash', ['user' => $user])
        @elseif($mode == 'add')
            @include('components.forms.user.create')
        @endif
    </x-blocks.form>

</main>

@endsection
