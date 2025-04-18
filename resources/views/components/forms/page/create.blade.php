<form method="POST" class="vlx-form" action="{{ route("dashboard.pages.store") }}" id="pageForm">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.input label="Page title" type="text" name="title" class="js-auto-update" attrs="required maxlength=255 data-auto-update=page-slug data-auto-update-parse=slugify" />
        <x-forms.input label="Slug" id="page-slug" type="text" name="slug" desc="Use {none} to dictate that a page should be accessable directly on / (like a homepage). note the page cant be reached via /{none}" />
    </div>

    <div class="vlx-form__box vlx-form__box--hor">
        @php
            $parents = ['' => 'No parent'];
            $pages = App\Models\Page::all();
            if (!empty($pages)) {
                foreach ($pages as $page) $parents[$page->id] = $page->title;
            }
        @endphp
        <x-forms.select label="Parent page" name="parent_id" :options="$parents" />
        <x-forms.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'private' => 'Private']" attrs="required" />
    </div>

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.text-area label="Excerpt" name="excerpt" attrs="maxlength=255"/>
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
        <input type="hidden" name="content" id="page-content" value="{{ json_encode([]) }}" />
    </div>
</form>
