@extends('layouts.app')

{{-- Page head --}}
@section('head')

<title>{{ $page->title }} || {{ env('APP_NAME') }}</title>

@endsection

{{-- Page content --}}
@section('content')
<main>
    @foreach (json_decode($page->content) as $block)
        @if(view()->exists('components.blocks.' . $block->template))
            <x-dynamic-component :component="'blocks.dynamic.' . $block->template" :block="$block" />
        @endif
    @endforeach
</main>
@endsection

