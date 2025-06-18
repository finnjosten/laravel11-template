@extends('layouts.app')

@section('show-nav', 'true')
<!-- Page head -->
@section('head')

<title>Contact || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

@php
    $contacts = App\Models\Contact::all();
@endphp

<main class="dash contact">
    @include('components.account.sidebar', ['page' => 'contact'])

    <section class="vlx-block vlx-block--dash-contact wst--large wsb--medium bg--normal">
        <div class="container">
            @if (!empty($contacts))

                <div class="vlx-block__header">
                    <div class="vlx-form">
                        <div class="vlx-form__box vlx-form__box--hor">
                            <div class="vlx-input-group">
                                <x-forms.input type="text" name="search" placeholder="Search through submissions..." class="js-search-input" />
                                <span class="vlx-icon--wrapper">
                                    <x-icon icon="magnifying-glass" size="small" />
                                </span>
                            </div>
                            <div class="vlx-input-group">
                                <p class="js-search-count">{{ count($contacts) }} @if (count($contacts) > 1) results @else result @endif</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="inner d-grid">
                    @foreach ($contacts as $contact)
                        <x-cards.contact :contact="$contact" />
                    @endforeach
                </div>

            @else

                <div class="vlx-empty">
                    <h2>No submissions found</h2>
                    <p>It seems you don't have any send in contact forms yet.</p>
                </div>

            @endif
        </div>
    </section>
</main>

@endsection
