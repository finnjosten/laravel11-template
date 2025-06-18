@extends('layouts.app')

@section('show-nav', 'true')

<!-- Page head -->
@section('head')

<title>Edit menu || {{ env('APP_NAME') }}</title>

<script>
    let menuItems = {!! json_encode($menu->items ?? []) !!};
</script>

<link rel="stylesheet" href="/css/menu-builder.css?{{ time() }}">
<script src="/js/menu-builder.js?{{ time() }}"></script>

{{-- <link rel="stylesheet" href="/css/menu-builder.min.css?{{ time() }}">
<script src="/js/menu-builder.min.js?{{ time() }}"></script> --}}

@endsection

<!-- Page content -->
@section('content')

<main class="dash menus">
    @include('components.account.sidebar', ['page' => 'menus'])

    <x-blocks.form class="wst--large wsb--medium bg--normal">
        <div class="vlx-block__header">
            <div class="btn-group btn-group--left">
                <a class="btn btn--primary btn--small" href="{{ route('dashboard.menus') }}">
                    <x-icon icon="arrow-left" size="small" />
                    Go back
                </a>

                @if($mode == "edit")
                    <a class="btn btn--primary btn--small btn--danger" href="{{ route('dashboard.menus.trash', $menu->id) }}">
                        <x-icon icon="trash" size="small" />
                        Delete
                    </a>
                @endif
            </div>
        </div>

        @if($mode == 'delete')
            @include('components.forms.menu.trash', ['menu' => $menu])
        @elseif($mode == 'edit')
            @include('components.forms.menu.edit', ['menu' => $menu])
        @elseif($mode == 'add')
            @include('components.forms.menu.create')
        @endif
    </x-blocks.form>
</main>
@endsection
