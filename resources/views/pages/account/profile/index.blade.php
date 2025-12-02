@extends('layouts.app')

@section('show-nav', 'true')

<!-- Page head -->
@section('head')

<title>Profile || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

@php
    $user = Auth::user();
@endphp

<main class="dash profile">
    @include('components.account.sidebar', ['page' => 'profile'])

    <x-blocks.form class="wst--large wsb--medium bg--normal" container-class="container--x-small">
        <div class="vlx-block__header">
            <div class="btn-group btn-group--left">
                <a class="btn btn--warning btn--small" href="{{ route('dashboard.main') }}">
                    <x-icon icon="arrow-left" size="small" />
                    Go back
                </a>
                <a class="btn btn--warning btn--small" href="{{ route('profile.edit') }}">
                    <x-icon icon="pencil" size="small" />
                    Edit
                </a>
            </div>
        </div>

        <div class="vlx-form">
            <div class="vlx-form__box vlx-form__box--hor">
                <x-forms.input label="Name" name="name" type="text" value="{{ $user->name }}" attrs="required readonly" />
                <x-forms.input label="Email" name="email" type="email" value="{{ $user->email }}" attrs="required readonly" />
            </div>

            <div class="vlx-form__box vlx-form__box">
                <x-forms.input label="Role" name="role" type="text" value="{{ $user->role->name }}" attrs="readonly" />
            </div>

            <div class="vlx-form__box vlx-form__box--hor">
                <x-forms.input label="Verified" name="verified" type="text" value="{{ $user->isVerified() ? 'Yes' : 'No' }}" attrs="readonly" />
                <x-forms.input label="Blocked" name="blocked" type="text" value="{{ $user->isBlocked() ? 'Yes' : 'No' }}" attrs="readonly" />
            </div>

            <form method="POST" class="vlx-form__box" action="{{ route('logout') }}">
                @csrf
                <button type="submit" name="logout" class="btn btn--danger btn--small">
                    <x-icon icon="arrow-right-from-line" size="small" />
                    Logout
                </button>
            </form>
        </form>
    </x-blocks.form>

</main>

@endsection
