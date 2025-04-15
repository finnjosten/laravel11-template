@extends('layouts.app')

<!-- Page head -->
@section('head')

<title>Over ons || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main>
    <x-blocks.header-subpage>
        <h1>
            Over ons
        </h1>
    </x-blocks.header-subpage>
    <x-blocks.text class="wst--medium wsb--medium">
        <h2>Lorem Ipsum?</h2>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>
    </x-blocks.text>
    <x-blocks.text-image class="wst--medium wsb--medium bg--normal" image="{{ asset('images/example-1.jpg') }}" image-alt="River with a forest and mountains in the background" media-align="right" split="50-50">
        <h2>Lorem Ipsum</h2>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>
    </x-blocks.text-image>
    <x-blocks.text class="wst--medium wsb--medium">
        <h2>Sit amet</h2>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>
    </x-blocks.text>
    <x-blocks.text-image class="wst--medium wsb--medium bg--normal" image="{{ asset('images/example-2.jpg') }}" image-alt="Forest with fog flowing through it" media-align="left" split="50-50">
        <h2>Lorem Ipsum</h2>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>
    </x-blocks.text-image>
</main>

@endsection
