@extends('layouts.app')

@section('show-nav', 'true')

<!-- Page head -->
@section('head')

<title>Pages || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

@php
    $pages = App\Models\Page::all();
@endphp

<main class="dash pages">
    @include('components.account.sidebar', ['page' => 'pages'])

    <section class="vlx-block vlx-block--dash-pages wst--large wsb--medium bg--normal">
        <div class="container">
            @if (!empty($pages))

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
                                <p class="js-search-count">{{ count($pages) }} @if (count($pages) > 1) results @else result @endif</p>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group btn-group--right">
                        <a href="{{ route('dashboard.pages.create') }}" class="btn btn--primary btn--small">
                            <x-icon icon="plus" size="small" />
                            Add page
                        </a>
                    </div>
                </div>

                <div class="inner d-grid js-search-items">
                    @foreach ($pages as $page)
                        <x-cards.pages :page="$page" />
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
