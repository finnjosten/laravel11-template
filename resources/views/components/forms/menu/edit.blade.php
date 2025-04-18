<form method="POST" class="vlx-form" action="{{ route("dashboard.menus.update", $menu->id) }}" id="menuForm">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <x-forms.input label="Menu name" name="name" type="text" attrs="required" :value="old('name', $menu->name)" />
        <x-forms.input label="Location" name="location" type="text" attrs="required" :value="old('location', $menu->location)" desc="Unique identifier for this menu (e.g., 'main', 'footer')" />
    </div>

    <div class="vlx-form__box">
        <x-forms.text-area label="Description" name="description" :value="old('description', $menu->description)" />
    </div>

    <div class="vlx-form__group">
        <label class="vlx-input-box__label h4">Menu Items</label>
        <div id="menuBuilder" class="vlx-menu-builder">
            <div class="vlx-menu-builder__actions">
                <button type="button" class="btn btn--small btn--primary" onclick="addMenuItem()">
                    <x-icon icon="plus" size="small" />
                    Add menu item
                </button>
            </div>
            <div id="menuItems" class="vlx-menu-builder__items">
                <!-- Menu items will be rendered here -->
            </div>
        </div>
    </div>

    <div class="vlx-form__box">
        <button type="submit" name="update" class="btn btn--success btn--small js-menu-update">
            <x-icon icon="floppy-disk" size="small" />
            Update
        </button>
    </div>

</form>

<template id="menuItemTemplate">
    <div class="vlx-menu-item" data-item-id="__ID__">
        <div class="vlx-menu-item__header">
            <div class="vlx-menu-item__title">
                <div class="vlx-menu-item__drag-handle"><x-icon icon="bars" /></div>
                <p class="js-menu-title">New Item</p>
            </div>

            <div class="btn-group btn-group--right">
                <button type="button" class="btn btn--small" onclick="toggleMenuItem(this)">
                    <x-icon icon="pencil" size="small" />
                    Edit
                </button>
                <button type="button" class="btn btn--small btn--darnger" onclick="removeMenuItem(this)">
                    <x-icon icon="trash" size="small" />
                    Remove
                </button>
            </div>
        </div>
        <div class="vlx-menu-item__content" style="display: none;">
            <div class="vlx-form__box">
                <x-forms.input label="Title" name="items[__ID__][title]" type="text" attrs="required" />
            </div>
            <div class="vlx-form__box vlx-form__box--hor">
                <x-forms.select label="Type" name="items[__ID__][type]" :options="['custom' => 'Custom', 'page' => 'Page']" attrs="onchange=handleMenuItemTypeChange(this)" />
                <x-forms.input label="URL" name="items[__ID__][url]" type="text" top-class="link-input" />

                @php
                    $options = [];
                    $pages = App\Models\Page::where('id', '!=', $page->id ?? null)->get();
                    if (!empty($pages)) {
                        foreach ($pages as $page) $options[$page->id] = $page->title;
                    }
                @endphp
                <x-forms.select label="Page" name="items[__ID__][page_id]" :options="$options" top-class="page-select" />
            </div>
            <div class="vlx-form__box vlx-form__box--hor">
                <x-forms.select label="Visibility" name="items[__ID__][visibility]" :options="['all' => 'All users', 'guest' => 'Guests only', 'auth' => 'Authenticated only']" />
                <x-forms.switch label="Extended visibility" sublabel="Admin only" name="items[__ID__][admin_only]" />
            </div>
            <button type="button" class="btn btn--primary btn--small js-sub-item-btn" onclick="addSubItem(this)">
                <x-icon icon="plus" size="small" />
                Add Sub-item
            </button>
        </div>
        <div class="vlx-menu-item__children"></div>
    </div>
</template>
