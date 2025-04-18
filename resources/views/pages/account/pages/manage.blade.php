@extends('layouts.app')

@section('show-nav', 'true')

<!-- Page head -->
@section('head')

<title>Edit page || {{ env('APP_NAME') }}</title>

<link rel="stylesheet" href="/css/block-editor.css?{{ time() }}">
<script src="/js/block-editor.js?{{ time() }}"></script>

<link rel="stylesheet" href="/js/wysiwyg/ui/trumbowyg.min.css">
<script src="/js/wysiwyg/trumbowyg.min.js"></script>

@endsection

<!-- Page content -->
@section('content')

<main class="dash pages">
    @include('components.account.sidebar', ['page' => 'pages'])

    <x-blocks.form class="wst--large wsb--medium bg--normal">
        <div class="vlx-block__header">
            <div class="btn-group btn-group--left">
                <a class="btn btn--primary btn--small" href="{{ route('dashboard.pages') }}">
                    <x-icon icon="arrow-left" size="small" />
                    Go back
                </a>

                @if($mode == "edit")
                    <a class="btn btn--primary btn--small btn--danger" href="{{ route('dashboard.pages.trash', $page->id) }}">
                        <x-icon icon="trash" size="small" />
                        Delete
                    </a>
                @endif
            </div>
        </div>

        @if($mode == 'delete')
            @include('components.forms.page.trash', ['page' => $page])
        @elseif($mode == 'edit')
            @include('components.forms.page.edit', ['page' => $page])
        @elseif($mode == 'add')
            @include('components.forms.page.create')
        @endif
    </x-blocks.form>
</main>

@endsection
