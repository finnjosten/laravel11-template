// Init all the JS after the dom is loaded
document.addEventListener('DOMContentLoaded', () => {
    initAutoUpdater();
    initSearchInputs();
    initPasswordToggles();
    initTabs();
});


function initAutoUpdater(){
    let updating_inputs = document.querySelectorAll('.js-auto-update');

    updating_inputs.forEach(input => {
        let updating_input_from = document.getElementById(input.getAttribute('data-auto-update'));
        console.log(input);
        console.log(updating_input_from);

        let prefix = input.getAttribute('data-auto-update-prefix') ?? "";
        let suffix = input.getAttribute('data-auto-update-suffix') ?? "";

        let parse = input.getAttribute('data-auto-update-parse');

        if (updating_input_from.value != null && updating_input_from.value != "") {
            return console.warn('Auto update input already has a value, skipping');
        }

        if (updating_input_from) {
            input.addEventListener('input', () => {
                let value = parseValue(input.value, parse);
                updating_input_from.value = prefix + value + suffix;
            });
        } else {
            // Get the nearest parent form and in that form find the input with the name
            let form = input.closest('form');
            let input_name = input.getAttribute('name');
            let updating_input_from = form.querySelector(`input[name="${input_name}"]`);

            if (updating_input_from) {
                input.addEventListener('input', () => {
                    let value = parseValue(input.value, parse);
                    updating_input_from.value = prefix + value + suffix;
                });
            }
        }
    });

    function parseValue(value = null, method = null) {
        if (!value) return value;
        if (!method) return value;

        if (method === 'json') {
            try { value = JSON.parse(value); } catch (e) {  return console.error('Invalid JSON:', value); }
        } else if (method === 'base64') {
            try { value = atob(value); } catch (e) {  return console.error('Invalid base64:', value); }
        } else if (method === 'urlencode') {
            try { value = decodeURIComponent(value); } catch (e) {  return console.error('Invalid URL:', value); }
        } else if (method === 'slugify') {
            value = value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        } else {
            console.error('Unknown parse method:', method);
            return value;
        }

        return value;
    }
}

function initSearchInputs() {

    const searchInput = document.querySelector('.js-search-input');
    const searchItems = document.querySelectorAll('.js-search-item');
    const searchCountElement = document.querySelector('.js-search-count');

    if (!searchInput || searchItems.length === 0) {
        return;
    }

    searchInput.addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        let visibleCount = 0;

        searchItems.forEach(item => {
            const searchables = item.querySelectorAll('.js-searchable');
            let found = false;

            searchables.forEach(searchable => {
                if (searchable.textContent.toLowerCase().includes(searchValue)) {
                    found = true;
                }
            });

            if (found) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Update the count text
        if (searchCountElement) {
            searchCountElement.textContent = visibleCount + (visibleCount === 1 ? ' result' : ' results');
        }
    });
}

function initPasswordToggles() {
    const passwordInputs = document.querySelectorAll('.js-password');
    const passwordBtns = document.querySelectorAll('.js-password-btn');

    passwordBtns.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            if (passwordInputs[index].type === 'password') {
                passwordInputs[index].type = 'text';
                btn.classList.remove('vlx-icon--eye');
                btn.classList.add('vlx-icon--eye-slash');
            } else {
                passwordInputs[index].type = 'password';
                btn.classList.add('vlx-icon--eye');
                btn.classList.remove('vlx-icon--eye-slash');
            }
        });
    });
}

function initTabs() {
    const buttons = document.querySelectorAll('[data-tab-target]');
    const tabs = document.querySelectorAll('[data-tab-id]');

    // Get the tab from the URL
    const url = new URL(window.location.href);
    const tab = url.searchParams.get('tab');
    if (tab) {
        tabs.forEach(tab => {
            tab.classList.remove('active');
        });
        buttons.forEach(button => {
            button.classList.remove('active');
        });
        document.querySelector(`[data-tab-id="${tab}"]`).classList.add('active');
        document.querySelector(`[data-tab-target="${tab}"]`).classList.add('active');
    }

    buttons.forEach(button => {
        button.addEventListener('click', () => {

            // Get the target tab
            const target = document.querySelector(`[data-tab-id="${button.dataset.tabTarget}"]`);

            tabs.forEach(tab => {
                tab.classList.remove('active');
            });
            buttons.forEach(button => {
                button.classList.remove('active');
            });
            target.classList.add('active');
            button.classList.add('active');

            // set parameter to active tab
            const url = new URL(window.location.href);
            url.searchParams.set('tab', button.dataset.tabTarget);
            window.history.pushState({}, '', url);
        });
    });

}






/**
 * Helper functions
**/

/**
 *  Get a cookie by its name returns the whole cookie string
 *
 * @param {string} cookie_name
 * @returns {string}
 */
function vlx_get_cookie(cookie_name) {
    return document.cookie.split(';').find(cookie => cookie.includes(cookie_name));
}


/**
 * Get a cookie by its name returns the value of the cookie
 *
 * @param {string} cookie_name
 * @returns {string}
 */
function vlx_get_cookie_val(cookie_name) {
    let cookie_val = document.cookie.split(';').find(cookie => cookie.includes(cookie_name));
    if (cookie_val) {
        return cookie_val.split('=')[1];
    }
    return '';
}


/**
 *  Set a cookie by its name, data and time
 *
 * @param {string} cookie_name
 * @param {*} data
 * @param {string} time
 * @returns {void}
 */
function vlx_set_cookie(cookie_name, data, time) {
    data = JSON.stringify(data);
    document.cookie = `${cookie_name}=${data}; expires=${time}; path=/`;
}

/**
 * Simpeler version for a setTimeout
 *
 * @param {int} ms
 * @returns {Promise}
 */
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}


/**
 * Reloads all the CSS files on the page, usually this is ran in dev tools from your browser
 *
 * @returns {string}
 */
function reloadcss() {
    document.querySelectorAll("link[rel=stylesheet]").forEach(link => link.href = link.href.replace(/\?.*|$/, "?" + Date.now()))
    return "CSS Reloading...";
}


/**
 * Will send a success toast message to the user
 *
 * @param {string} message
 * @param {string} second_message
 */
function toastSuccess(message, second_message) {
    showToast('success', message, second_message);
    console.log(message, second_message);
}


/**
 * Will send a info toast message to the user
 *
 * @param {string} message
 * @param {string} second_message
 */
function toastInfo(message, second_message) {
    showToast('info', message, second_message);
    console.info(message, second_message);
}


/**
 * Will send a warning toast message to the user
 *
 * @param {string} message
 * @param {string} second_message
 */
function toastWarning(message, second_message) {
    showToast('warn', message, second_message);
    console.warn(message, second_message);
}


/**
 * Will send a error toast message to the user
 *
 * @param {string} message
 * @param {string} second_message
 */
function toastError(message, second_message) {
    showToast('error', message, second_message);
    console.error(message, second_message);
}

/**
 * Common function to show toast messages
 *
 * @param {string} type - The toast type (success, info, warning, error)
 * @param {string} message - Primary message to display
 * @param {string} second_message - Optional secondary message
 */
function showToast(type, message, second_message) {
    if (isToastrAvailable()) {
        toastr[type](message);
        if (second_message) {
            toastr[type](second_message);
        }
    }

    if (isNotyfAvailable()) {
        notyf.open({type, message});
        if (second_message) {
            notyf.open({type, message: second_message});
        }
    }
}


/**
 * Checks if toastr is available to send toasts
 *
 * @returns {boolean}
 */
function isToastrAvailable() {
    return typeof toastr !== 'undefined' && toastr !== null;
}


/**
 * Checks if notyf is available to send toasts
 *
 * @returns {boolean}
 */
function isNotyfAvailable() {
    return typeof Notyf !== 'undefined' && Notyf !== null;
}
