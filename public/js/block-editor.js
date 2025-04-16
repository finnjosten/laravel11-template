
const defaultSettings = {
    wst: {
        type: 'select',
        options: [
            { value: 'none', label: 'None' },
            { value: 'large', label: 'Large' },
            { value: 'medium', label: 'Medium' },
            { value: 'small', label: 'Small' }
        ],
        default: 'large',
    },
    wsb: {
        type: 'select',
        options: [
            { value: 'none', label: 'None' },
            { value: 'large', label: 'Large' },
            { value: 'medium', label: 'Medium' },
            { value: 'small', label: 'Small' }
        ],
        default: 'large',
    },
    bg: {
        type: 'select',
        options: [
            { value: 'light', label: 'Light' },
            { value: 'normal', label: 'Normal' },
            { value: 'dark', label: 'Dark' }
        ],
        default: 'normal',
    }
}
const blockTypes = {
    headerHome: {
        template: 'header-home',
        name: 'Header Home',
        icon: '🏠',
        settings: {
            text: {
                type: 'wysiwyg',
                default: ''
            },
            imageUrl: {
                type: 'text',
                default: ''
            },
            imageAlt: {
                type: 'text',
                default: ''
            }
        }
    },
    headerSubpage: {
        template: 'header-subpage',
        name: 'Header Subpage',
        icon: '📑',
        settings: {
            text: {
                type: 'wysiwyg',
                default: ''
            },
            imageUrl: {
                type: 'text',
                default: ''
            },
            imageAlt: {
                type: 'text',
                default: ''
            },
        }
    },
    text: {
        template: 'text',
        name: 'Text Block',
        icon: '📝',
        settings: {
            text1: {
                type: 'wysiwyg',
                default: ''
            },
            text2: {
                type: 'wysiwyg',
                default: ''
            },
            title: {
                type: 'text',
                default: ''
            },
            split: {
                type: 'select',
                options: [
                    { value: '100-0', label: '100-0' },
                    { value: '75-25', label: '75-25' },
                    { value: '67-33', label: '67-33' },
                    { value: '50-50', label: '50-50' },
                    { value: '33-67', label: '33-67' },
                    { value: '25-75', label: '25-75' },
                    { value: '0-100', label: '0-100' },
                ],
                default: '50-50',
            },
            buttons: {
                type: 'array',
                default: []
            },
        }
    },
    textImage: {
        template: 'text-image',
        name: 'Text with Image',
        icon: '🖼️',
        settings: {
            text: {
                type: 'wysiwyg',
                default: ''
            },
            imageUrl: {
                type: 'text',
                default: ''
            },
            imageAlt: {
                type: 'text',
                default: ''
            },
            buttons: {
                type: 'array',
                default: []
            },
            split: {
                type: 'select',
                options: [
                    { value: '100-0', label: '100-0' },
                    { value: '75-25', label: '75-25' },
                    { value: '67-33', label: '67-33' },
                    { value: '50-50', label: '50-50' },
                    { value: '33-67', label: '33-67' },
                    { value: '25-75', label: '25-75' },
                    { value: '0-100', label: '0-100' },
                ],
                default: '50-50',
            },
            mediaAlign: {
                type: 'select',
                options: [
                    { value: 'left', label: 'Left' },
                    { value: 'right', label: 'Right' }
                ],
                default: 'left',
            }
        }
    }
};
const blockIgnoreDefaults = ["headerHome", "headerSubpage",]


class BlockEditor {
    constructor() {
        this.blocks = [];
        this.currentDraggedBlock = null;
        this.init();
        this.loadContent();
        this.allowDragging = false;
    }

    init() {
        this.setupEventListeners();
        this.setupBlockTypesMenu();
        this.setupDragAndDrop();
    }

    setupEventListeners() {
        // Add block button
        document.querySelector('.js-add-block').addEventListener('click', () => {
            const menu = document.querySelector('.js-block-menu');
            menu.classList.toggle('--active');
        });

        // Close block types menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.js-add-block') && !e.target.closest('.js-block-menu')) {
                document.querySelector('.js-block-menu').classList.remove('--active');
            }
        });

        // Form submission
        document.getElementById('pageForm').addEventListener('submit', () => {
            this.updateContentInput();
        });

        // listen to commen save keybinds and save the form
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.querySelector(".js-save-blocks").click();
            }
        });
    }

    setupBlockTypesMenu() {
        const menu = document.querySelector('.js-block-menu');

        Object.entries(blockTypes).forEach(([type, block]) => {
            const button = document.createElement('button');
            button.innerHTML = `${block.icon} ${block.name}`;
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.addBlock(type);
                menu.classList.remove('--active');
            });
            menu.appendChild(button);
        });
    }

    setupDragAndDrop() {
        const container = document.querySelector('.js-blocks-container');

        container.addEventListener('dragover', e => {
            e.preventDefault();
            const afterElement = this.getDragAfterElement(container, e.clientY);
            const draggable = document.querySelector('.--dragging');
            if (draggable) {
                if (afterElement) {
                    container.insertBefore(draggable, afterElement);
                } else {
                    container.appendChild(draggable);
                }
            }
        });

        container.addEventListener('dragend', () => {
            this.syncBlocksOrderWithDOM();
            this.updateContentInput();
        });
    }

    loadContent() {
        const contentInput = document.getElementById('page-content');
        try {
            let content = contentInput.value;
            // Try to parse if it's a JSON string
            try {
                content = JSON.parse(content);
            } catch (e) {
                // Value might already be decoded by PHP
                console.warn('First JSON parse failed, value might already be decoded');
            }

            // Ensure content is an array
            if (Array.isArray(content)) {
                this.blocks = content;
            } else if (typeof content === 'string') {
                // Try parsing one more time in case of double encoding
                try {
                    const parsed = JSON.parse(content);
                    this.blocks = Array.isArray(parsed) ? parsed : [];
                } catch (e) {
                    console.error('Failed to parse content as JSON', e);
                    this.blocks = [];
                }
            } else {
                this.blocks = [];
            }

            this.refreshBlocksContainer();
        } catch (error) {
            console.error('Error loading content:', error);
            this.blocks = [];
        }
    }

    updateContentInput() {
        const contentInput = document.getElementById('page-content');
        console.log(this.blocks);
        contentInput.value = JSON.stringify(this.blocks);
    }

    addBlock(type) {
        const block = {
            id: `block-${Date.now()}`,
            type,
            template: blockTypes[type].template,
            settings: { ...this.getDefaultSettings(type) }
        };

        this.blocks.push(block);
        this.renderBlock(block, type);
        this.updateContentInput();
    }

    getDefaultSettings(type) {
        const settings = {};
        let loopSettings
        if (blockIgnoreDefaults.includes(type)) {
            loopSettings = blockTypes[type].settings;
        } else {
            loopSettings = {...defaultSettings, ...blockTypes[type].settings};
        }
        Object.entries(loopSettings).forEach(([key, setting]) => {
            settings[key] = setting.default;
        });
        return settings;
    }

    renderBlock(block, type) {
        const container = document.createElement('div');
        container.className = 'vlx-be-block';
        container.id = block.id;
        if (this.allowDragging) container.draggable = true;

        if (this.allowDragging) {
            container.addEventListener('dragstart', () => {
                container.classList.add('--dragging');
            });
        }

        container.addEventListener('dragend', () => {
            container.classList.remove('--dragging');
        });

        const header = document.createElement('div');
        header.className = 'vlx-be-block__header';

        const title = document.createElement('h5');
        title.innerHTML = `${blockTypes[block.type].icon} ${blockTypes[block.type].name}`;

        const controls = document.createElement('div');
        controls.className = 'vlx-be-block-controls';

        // Move up button
        const moveUpBtn = document.createElement('button');
        moveUpBtn.innerHTML = '↑';
        moveUpBtn.addEventListener('click', (e) => this.moveBlock(e, block, -1));

        // Move down button
        const moveDownBtn = document.createElement('button');
        moveDownBtn.innerHTML = '↓';
        moveDownBtn.addEventListener('click', (e) => this.moveBlock(e, block, 1));

        // Delete button
        const deleteBtn = document.createElement('button');
        deleteBtn.innerHTML = '🗑️';
        deleteBtn.addEventListener('click', () => this.deleteBlock(block));

        controls.append(moveUpBtn, moveDownBtn, deleteBtn);
        header.append(title, controls);

        const content = document.createElement('div');
        content.className = 'vlx-be-block__content';

        // Render settings directly in the block
        content.innerHTML = this.renderBlockSettings(block, type);

        // Add change event listeners to inputs
        container.append(header, content);
        document.querySelector('.js-blocks-container').appendChild(container);

        // Add event listeners for all inputs after they're in the DOM
        this.setupBlockSettingsListeners(block);
    }

    renderBlockSettings(block, type) {
        let settings;
        if (blockIgnoreDefaults.includes(type)) {
            settings = blockTypes[block.type].settings;
        } else {
            settings = {...blockTypes[block.type].settings, ...defaultSettings};
        }

        settings = this.filterSettings(settings);

        let html = [];
        let pairBuffer = [];

        // Do some fun pairing. we pair 2 normal inputs with each other so they are side by side and leave the WYSIWYG and buttons to be alone in a full width box
        Object.entries(settings).forEach(([key, setting]) => {
            if (setting.type === 'wysiwyg') {
                // Flush any existing pair buffer
                if (pairBuffer.length > 0) {
                    html.push(`<div class="vlx-form__box vlx-form__box--pair">${pairBuffer.join('')}</div>`);
                    pairBuffer = [];
                }

                // Add wysiwyg as full width
                html.push(`
                    <div class="vlx-form__box">
                        <div class="vlx-input-box">
                            <label class="h4" for="${block.id}-${key}">${this.formatSettingLabel(key)}</label>
                            ${this.renderSettingInput(block.id, key, setting, block.settings[key])}
                        </div>
                    </div>
                `);
            } else if (setting.type === 'array' && key === 'buttons') {
                // Flush any existing pair buffer
                if (pairBuffer.length > 0) {
                    html.push(`<div class="vlx-form__box vlx-form__box--hor">${pairBuffer.join('')}</div>`);
                    pairBuffer = [];
                }

                // Add buttons as full width
                html.push(`
                    <div class="vlx-form__box">
                        <div class="vlx-input-box">
                            <label class="h4" for="${block.id}-${key}">${this.formatSettingLabel(key)}</label>
                            ${this.renderSettingInput(block.id, key, setting, block.settings[key])}
                        </div>
                    </div>
                `);
            } else {
                // Add to pair buffer
                pairBuffer.push(`
                    <div class="vlx-input-box">
                        <label class="h4" for="${block.id}-${key}">${this.formatSettingLabel(key)}</label>
                        ${this.renderSettingInput(block.id, key, setting, block.settings[key])}
                    </div>
                `);

                // If we have a pair, add it to html and clear buffer
                if (pairBuffer.length === 2) {
                    html.push(`<div class="vlx-form__box vlx-form__box--hor">${pairBuffer.join('')}</div>`);
                    pairBuffer = [];
                }
            }
        });

        // Handle any remaining unpaired items
        if (pairBuffer.length > 0) {
            html.push(`<div class="vlx-form__box vlx-form__box--hor">${pairBuffer.join('')}</div>`);
        }

        return html.join('');
    }

    filterSettings(settings) {
        // filter the settings so the WYIWYG editor is always first and buttons always last rest can stay in the normal order
        const filteredSettings = {};
        const wysiwygKeys = Object.keys(settings).filter(key => settings[key].type === 'wysiwyg');
        const buttonKeys = Object.keys(settings).filter(key => settings[key].type === 'array' && key === 'buttons');
        const otherKeys = Object.keys(settings).filter(key => !wysiwygKeys.includes(key) && !buttonKeys.includes(key));
        const orderedKeys = [...wysiwygKeys, ...otherKeys, ...buttonKeys];
        orderedKeys.forEach(key => {
            filteredSettings[key] = settings[key];
        });
        return filteredSettings;
    }

    formatSettingLabel(key) {
        return key
            .replace(/([A-Z])/g, ' $1') // Add space before capital letters
            .replace(/^./, str => str.toUpperCase()); // Capitalize first letter
    }

    renderSettingInput(blockId, key, setting, value) {
        if (setting.type === 'wysiwyg') {
            return `<textarea
                id="${blockId}-${key}"
                class="wysiwyg-editor"
                data-wysiwyg="true"
                data-setting="${key}">${value || ''}</textarea>`;
        } else if (setting.type === 'textarea') {
            return `<textarea
                id="${blockId}-${key}"
                data-setting="${key}">${value || ''}</textarea>`;
        } else if (setting.type === 'select') {
            return `<select id="${blockId}-${key}" data-setting="${key}">
                ${setting.options.map(option => `
                    <option value="${option.value}" ${option.value === value ? 'selected' : (option.value === setting.default ? 'selected' : '')}>
                        ${option.label}
                    </option>`).join('')}
            </select>`;
        } else if (setting.type === 'array' && key === 'buttons') {
            const buttons = Array.isArray(value) ? value : [];
            return `
                <div class="buttons-editor">
                    <div class="buttons-list" id="${blockId}-buttons">
                        ${buttons.map((btn, index) => this.renderButtonItem(blockId, index, btn)).join('')}
                    </div>
                    <button type="button" class="add-button" data-block-id="${blockId}">Add Button</button>
                </div>
            `;
        } else {
            return `<input
                type="text"
                id="${blockId}-${key}"
                value="${value || ''}"
                data-setting="${key}">`;
        }
    }

    renderButtonItem(blockId, index, button = {}) {
        return `
            <div class="button-item" data-index="${index}">
                <input type="text"
                    class="button-title"
                    value="${button.title || ''}"
                    placeholder="Button Text"
                    data-block-id="${blockId}">
                <input type="text"
                    class="button-url"
                    value="${button.url || ''}"
                    placeholder="URL"
                    data-block-id="${blockId}">
                <select class="button-target" data-block-id="${blockId}">
                    <option value="_self" ${button.target === '_self' ? 'selected' : ''}>Same Window</option>
                    <option value="_blank" ${button.target === '_blank' ? 'selected' : ''}>New Window</option>
                </select>
                <button type="button" class="remove-button" data-block-id="${blockId}">Remove</button>
            </div>
        `;
    }

    setupBlockSettingsListeners(block) {
        const blockElement = document.getElementById(block.id);

        // Initialize WYSIWYG editors
        blockElement.querySelectorAll('textarea[data-wysiwyg="true"]').forEach(textarea => {
            $(textarea).trumbowyg({
                btns: [
                    ['viewHTML'],
                    ['formatting'],
                    ['strong', 'em'],
                    ['link'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight'],
                    ['unorderedList', 'orderedList'],
                    ['removeformat']
                ],
                removeformatPasted: false,
                autogrow: true
            });

            // Listen for Trumbowyg change event
            $(textarea).on('tbwchange', () => {
                const setting = textarea.dataset.setting;
                block.settings[setting] = textarea.value;
                this.updateContentInput();
            });
        });

        // Listen for changes on regular inputs and textareas
        blockElement.querySelectorAll('input[data-setting], textarea[data-setting], select[data-setting]').forEach(input => {
            input.addEventListener('input', (e) => {
                const setting = e.target.dataset.setting;
                block.settings[setting] = e.target.value;
                this.updateContentInput();
            });
        });

        // Setup button handlers
        const buttonsContainer = blockElement.querySelector('.buttons-list');
        if (buttonsContainer) {
            // Add button handler
            blockElement.querySelector('.add-button').addEventListener('click', () => {
                const newButtonHtml = this.renderButtonItem(block.id, buttonsContainer.children.length);
                const temp = document.createElement('div');
                temp.innerHTML = newButtonHtml;
                buttonsContainer.appendChild(temp.firstElementChild);
                this.updateButtonsArray(block);
                this.updateContentInput();
            });

            // Remove button and input change handlers using event delegation
            buttonsContainer.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-button')) {
                    e.target.closest('.button-item').remove();
                    this.updateButtonsArray(block);
                    this.updateContentInput();
                }
            });

            buttonsContainer.addEventListener('input', (e) => {
                if (e.target.matches('.button-title, .button-url, .button-target')) {
                    this.updateButtonsArray(block);
                    this.updateContentInput();
                }
            });

            buttonsContainer.addEventListener('change', (e) => {
                if (e.target.matches('.button-target')) {
                    this.updateButtonsArray(block);
                    this.updateContentInput();
                }
            });
        }
    }

    updateButtonsArray(block) {
        const blockElement = document.getElementById(block.id);
        const buttons = [];

        blockElement.querySelectorAll('.button-item').forEach(item => {
            buttons.push({
                title: item.querySelector('.button-title').value,
                url: item.querySelector('.button-url').value,
                target: item.querySelector('.button-target').value
            });
        });

        block.settings.buttons = buttons;
    }

    moveBlock(e, block, direction) {
        e.preventDefault();
        const currentIndex = this.blocks.indexOf(block);
        const newIndex = currentIndex + direction;

        if (newIndex >= 0 && newIndex < this.blocks.length) {
            // Update array
            this.blocks.splice(currentIndex, 1);
            this.blocks.splice(newIndex, 0, block);

            // Update DOM
            this.refreshBlocksContainer();
            this.updateContentInput();
            // scroll to the moved block
            const movedBlockElement = document.getElementById(block.id);
            if (movedBlockElement) {
                movedBlockElement.scrollIntoView({ block: 'nearest' });
            }
        }
    }

    deleteBlock(block) {
        const index = this.blocks.indexOf(block);
        if (index > -1) {
            this.blocks.splice(index, 1);
            document.getElementById(block.id).remove();
            this.updateContentInput();
        }
    }

    refreshBlocksContainer() {
        const container = document.querySelector('.js-blocks-container');
        container.innerHTML = '';
        this.blocks.forEach(block => this.renderBlock(block));
    }

    syncBlocksOrderWithDOM() {
        console.log('Syncing blocks order with DOM...');
        const container = document.querySelector('.js-blocks-container');
        const newBlocks = [];
        const blockElements = container.querySelectorAll('.block');

        console.log('Current blocks:', this.blocks);
        console.log('DOM elements:', blockElements);

        blockElements.forEach(blockElement => {
            const blockId = blockElement.id;
            const block = this.blocks.find(b => b.id === blockId);
            if (block) {
                newBlocks.push(block);
            }
        });

        console.log('New blocks order:', newBlocks);
        this.blocks = newBlocks;
        this.updateContentInput();
    }

    getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.block:not(.--dragging)')];

        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;

            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }
}

// Initialize the block editor when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.blockEditor = new BlockEditor();
});
