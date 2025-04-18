@extends('layouts.app')

@section('show-nav', 'true')

<!-- Page head -->
@section('head')

<title>Menus || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

@php
    $menus = App\Models\Menu::all();
@endphp

<main class="dash users">
    @include('components.account.sidebar', ['page' => 'pages'])

    <section class="vlx-block vlx-block--dash-menus wst--large wsb--medium bg--normal">
        <div class="container">
            @if (!empty($menus))

                <div class="vlx-block__header">
                    <div class="vlx-form">
                        <div class="vlx-form__box vlx-form__box--hor">
                            <div class="vlx-input-group">
                                <x-forms.input type="text" name="search" placeholder="Search through pages..." class="js-search-input" />
                                <span class="vlx-icon--wrapper">
                                    <x-icon icon="magnifying-glass" size="small" />
                                </span>
                            </div>
                            <div class="vlx-input-group">
                                <p class="js-search-count">{{ count($menus) }} @if (count($menus) > 1) results @else result @endif</p>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group btn-group--right">
                        <a href="{{ route('dashboard.menus.create') }}" class="btn btn--primary btn--small">
                            <x-icon icon="plus" size="small" />
                            Add menu
                        </a>
                    </div>
                </div>

                <div class="inner d-grid js-search-items">
                    @foreach ($menus as $menu)
                        <x-cards.menus :menu="$menu" />
                    @endforeach
                </div>

            @else

                <div class="vlx-empty">
                    <h2>No users found</h2>
                    <p>It seems you don't have any users yet.</p>
                </div>

            @endif
        </div>
    </section>
</main>

@endsection
