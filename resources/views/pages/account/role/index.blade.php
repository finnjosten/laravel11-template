@extends('layouts.app')

@section('show-nav', 'true')

<!-- Page head -->
@section('head')

<title>Roles || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

@php
    $roles = App\Models\Role::all();
@endphp

<main class="dash roles">
    @include('components.account.sidebar', ['page' => 'role'])

    <section class="vlx-block vlx-block--dash-roles wst--large wsb--medium bg--normal">
        <div class="container">
            @if (!empty($roles))

                <div class="vlx-block__header">
                    <div class="vlx-form">
                        <div class="vlx-form__box vlx-form__box--hor">
                            <div class="vlx-input-group">
                                <x-forms.input type="text" name="search" placeholder="Search roles..." class="js-search-input" />
                                <span class="vlx-icon--wrapper">
                                    <x-icon icon="magnifying-glass" size="small" />
                                </span>
                            </div>
                            <div class="vlx-input-group">
                                <p class="js-search-count">{{ count($roles) }} @if (count($roles) > 1) results @else result @endif</p>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group btn-group--right">
                        <a href="{{ route('dashboard.role.create') }}" class="btn btn--primary btn--small">
                            <x-icon icon="plus" size="small" />
                            Add role
                        </a>
                    </div>
                </div>

                <div class="inner d-grid js-search-items">
                    @foreach ($roles as $role)
                        <x-cards.role :role="$role" />
                    @endforeach
                </div>

            @else

                <div class="vlx-empty">
                    <h2>No roles found</h2>
                    <p>It seems you don't have any roles yet.</p>
                </div>

            @endif
        </div>
    </section>
</main>

@endsection
