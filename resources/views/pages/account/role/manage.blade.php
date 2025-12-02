@extends('layouts.app')

@section('show-nav', 'true')

<!-- Page head -->
@section('head')

<title>Edit role || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main class="dash roles">
    @include('components.account.sidebar', ['page' => 'role'])

    <x-blocks.form class="wst--large wsb--medium bg--normal" container-class="container--x-small">
        <div class="vlx-block__header">
            <div class="btn-group btn-group--left">
                <a class="btn btn--primary btn--small" href="{{ route('dashboard.role') }}">
                    <x-icon icon="arrow-left" size="small" />
                    Go back
                </a>

                @if($mode == "edit")
                    <a class="btn btn--primary btn--small btn--danger" href="{{ route('dashboard.role.trash', $role->id) }}">
                        <x-icon icon="trash" size="small" />
                        Delete
                    </a>
                @endif
            </div>
        </div>

        @if($mode == 'edit')
            @include('components.forms.role.edit', ['role' => $role])
        @elseif($mode == 'delete')
            @include('components.forms.role.trash', ['role' => $role])
        @elseif($mode == 'add')
            @include('components.forms.role.create')
        @endif
    </x-blocks.form>

</main>

@endsection
