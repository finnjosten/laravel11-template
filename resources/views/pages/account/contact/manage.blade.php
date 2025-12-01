@extends('layouts.app')

@section('show-nav', 'true')

<!-- Page head -->
@section('head')

<title>Edit contact || {{ env('APP_NAME') }}</title>

<link rel="stylesheet" href="/css/datatables.css?v=1.13.7" />
<script src="/js/datatables.js?v=1.13.7"></script>

@endsection

<!-- Page content -->
@section('content')

<main class="dash contact">
    @include('components.account.sidebar', ['page' => 'contact'])

    <x-blocks.form class="wst--large wsb--medium bg--normal" container-class="container--x-small">
        <div class="vlx-block__header">
            <div class="btn-group btn-group--left">
                <a class="btn btn--primary btn--small" href="{{ route('dashboard.contact') }}">
                    <x-icon icon="arrow-left" size="small" />
                    Go back
                </a>

                @if($mode == "edit")
                    <a class="btn btn--primary btn--small btn--danger" href="{{ route('dashboard.contact.trash', $contact->id) }}">
                        <x-icon icon="trash" size="small" />
                        Delete
                    </a>
                @endif
            </div>
        </div>

        @if($mode == 'delete')
            @include('components.forms.contact.trash', ['contact' => $contact]   )
        @elseif($mode == 'view')
            @include('components.forms.contact.view', ['contact' => $contact]   )
        @endif
    </x-blocks.form>

</main>

@endsection
