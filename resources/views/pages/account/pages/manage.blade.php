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

<main class="dash users">
    @include('components.account.sidebar', ['page' => 'user'])

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
            <form method="POST" action="{{ route('dashboard.pages.delete', $page->id) }}">
                @csrf
                <div class="vlx-form__box">
                    <p>Page Title: <strong>{{ $page->title }}</strong></p>
                    <p>Page Slug: <strong>{{ $page->slug }}</strong></p>
                </div>
                <div class="btn-group btn-group--left">
                    <a href="{{ route('dashboard.pages') }}" class="btn btn--secondary">Cancel</a>
                    <button type="submit" class="btn btn--danger">Delete Page</button>
                </div>
            </form>
        @else
            <form method="POST" action="{{ $mode == 'edit' ? route('dashboard.pages.update', $page->id) : route('dashboard.pages.store') }}" id="pageForm">
                @csrf
                <div class="vlx-form__box vlx-form__box--hor">
                    <x-forms.input label="Page title" type="text" name="title" value="{{ old('title', $page->title ?? '') }}" attrs="required maxlength=64" />
                    <x-forms.input label="Slug" type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}" attrs="required" />
                </div>
                <div class="vlx-form__box vlx-form__box--hor">
                    @php
                        $parents = ['' => 'No parent'];
                        $pages = App\Models\Page::where('id', '!=', $page->id ?? null)->get();
                        if (!empty($pages)) {
                            foreach ($pages as $p) $parents[$p->id] = $p->title;
                        }
                    @endphp
                    <x-forms.select label="Parent page" name="parent_id" :options="$parents" :selected="old('parent_id', $page->parent_id ?? '')" />
                    <x-forms.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'private' => 'Private']" :selected="old('status', $page->status ?? '')" attrs="required" />
                </div>
                <div class="vlx-form__box vlx-form__box--hor">
                    <x-forms.text-area label="Excerpt" name="excerpt" value="{{ old('excerpt', $page->excerpt ?? '') }}" attrs="maxlength=255"/>
                </div>

                <div class="vlx-block-editor">

                    <div class="vlx-block-types">
                        <div class="btn-group btn-group--left">
                            {{-- Add block to BE --}}
                            <button type="button" class="btn btn--info btn--small js-add-block">
                                <x-icon icon="plus" size="small" />
                                Add Block
                            </button>
                            {{-- Save button --}}
                            <button type="submit" name="update" class="btn btn--success btn--small js-save-blocks">
                                <x-icon icon="floppy-disk" size="small" />
                                Save
                            </button>
                        </div>
                        <div class="vlx-block-types__menu js-block-menu">
                            {{-- Block types will be populated by JavaScript --}}
                        </div>
                    </div>

                    <div class="vlx-block-editor__container js-blocks-container">
                        {{-- Blocks will be populated by JavaScript --}}
                    </div>

                    {{-- Input with all the contets, the controller reads this input to save the content --}}
                    @php
                        $blocks = [];
                        if (!empty($page->content)) {
                            $blocks = is_string($page->content)
                                ? json_decode($page->content)
                                : $page->content;
                        }
                        $blocks = json_encode($blocks);
                    @endphp
                    <input type="hidden" name="content" id="page-content" value="{{ $blocks }}">
                </div>
            </form>
        @endif
    </x-blocks.form>
</main>

@endsection
