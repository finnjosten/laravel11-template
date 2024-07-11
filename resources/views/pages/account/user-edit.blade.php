@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Edit categories || {{ env('APP_NAME') }}</title>

<link rel="stylesheet" href="/css/datatables.css?v=1.13.7" />
<script src="/js/datatables.js?v=1.13.7"></script>

@endsection

<!-- Page content -->
@section('content')

    <main class="page page--account view view--menu">
        @include('components.account.sidebar', ['page' => 'user'])
        <div class="content">
            <div class="btn-group">
                <a class="btn btn--primary btn--small" href="{{ route('dashboard.user') }}"><i class="da-icon da-icon--arrow-left da-icon--small"></i>Go back</a>
                @if($mode == "edit")
                    <a class="btn btn--primary btn--small btn--danger" href="{{ route('dashboard.user.trash', $user->id) }}"><i class="da-icon da-icon--trash da-icon--small"></i>Delete</a>
                @endif
            </div>

            @if($mode == 'edit')
                @include('components.forms.user.edit', ['user' => $user])
            @elseif($mode == 'delete')
                @include('components.forms.user.trash', ['user' => $user]   )
            @endif

        </div>
    </main>

@endsection
