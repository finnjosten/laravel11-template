let nextId = 1;

function addMenuItem(parentElement = null) {
    const template = document.getElementById('menuItemTemplate').innerHTML;
    const newItem = template.replaceAll('__ID__', nextId++);

    const container = parentElement ?
        parentElement.querySelector('.vlx-menu-item__children') :
        document.getElementById('menuItems');

    container.insertAdjacentHTML('beforeend', newItem);
    initializeSortable(container);
}

function toggleMenuItem(button) {
    const item = button.closest('.vlx-menu-item');
    const content = item.querySelector('.vlx-menu-item__content');
    content.style.display = content.style.display === 'none' ? 'block' : 'none';
}

function removeMenuItem(button) {
    const item = button.closest('.vlx-menu-item');
    item.remove();
}

function handleMenuItemTypeChange(select) {
    const item = select.closest('.vlx-menu-item');
    const link = item.querySelector('.link-input');
    const linkInput = item.querySelector('.link-input input');
    const page = item.querySelector('.page-select');
    const pageInput = item.querySelector('.page-select select');

    if (select.value === 'custom') {
        link.style.display = 'block';
        page.style.display = 'none';
    } else {
        link.style.display = 'none';
        page.style.display = 'block';
        link.value = null;
    }
}

function addSubItem(button) {
    const parentItem = button.closest('.vlx-menu-item');
    addMenuItem(parentItem);
}

function initializeSortable(element) {
    new Sortable(element, {
        group: 'menu-items',
        handle: '.vlx-menu-item__drag-handle',
        animation: 150
    });
}

// Initialize existing menu items
document.addEventListener('DOMContentLoaded', function () {
    initializeSortable(document.getElementById("menuItems"));

    if (menuItems.length) {
        renderMenuItems(menuItems);
    }

    initFormSubmit();
});

function renderMenuItems(items, parentElement = null) {
    items.forEach(item => {
        const template = document.getElementById('menuItemTemplate').innerHTML;
        const newItem = template.replaceAll('__ID__', nextId++);
        const container = parentElement ?
            parentElement.querySelector('.vlx-menu-item__children') :
            document.getElementById('menuItems');

        container.insertAdjacentHTML('beforeend', newItem);

        const itemElement = container.lastElementChild;

        // Set values
        itemElement.querySelector('.js-menu-title').innerHTML = item.title;
        itemElement.querySelector('[name$="[title]"]').value = item.title;
        itemElement.querySelector('[name$="[visibility]"]').value = item.visibility || 'all';
        itemElement.querySelector('[name$="[admin_only]"]').checked = item.admin_only;

        const typeSelect = itemElement.querySelector('[name$="[type]"]');
        if (!item.url) {
            typeSelect.value = 'page';
            itemElement.querySelector('[name$="[page_id]"]').value = item.page_id;
        } else {
            typeSelect.value = 'custom';
            itemElement.querySelector('[name$="[url]"]').value = item.url || '';
        }

        handleMenuItemTypeChange(typeSelect);

        if (item.children && item.children.length) {
            renderMenuItems(item.children, itemElement);
        }
    });
}

// Form submission
function initFormSubmit() {
    document.querySelector('.js-menu-update').addEventListener('click', function (e) {
        e.preventDefault();
        form = document.querySelector('#menuForm');

        // Convert form data to structured menu items
        const menuItems = [];
        const items = document.getElementById('menuItems').children;

        Array.from(items).forEach(item => {
            menuItems.push(processMenuItem(item));
        });

        console.log(menuItems);

        // Add menu items to form data
        const itemsInput = document.createElement('input');
        itemsInput.type = 'hidden';
        itemsInput.name = 'items';
        itemsInput.value = JSON.stringify(menuItems);
        form.appendChild(itemsInput);

        form.submit();
    });
}

function processMenuItem(element) {
    const item = {};
    const inputs = element.querySelectorAll('input, select');
    inputs.forEach(input => {
        const name = input.name.match(/\[([^\]]+)\]$/)[1];
        if (input.type === 'checkbox') {
            item[name] = input.checked;
        } else {
            item[name] = input.value;
        }
    });

    const children = element.querySelector('.vlx-menu-item__children').children;
    if (children.length) {
        item.children = Array.from(children).map(child => processMenuItem(child));
    }

    return item;
}
