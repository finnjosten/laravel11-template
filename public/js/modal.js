document.addEventListener('DOMContentLoaded', () => {
    initModalSetup();
});

function initModalSetup() {
    let modal_btns = document.querySelectorAll('.js-toggle-modal');

    modal_btns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            let modal_id = btn.getAttribute('data-target-modal');
            let modal = document.getElementById('vlx-' + modal_id);

            initModal(modal, btn);
        });
    });
}


async function initModal(modal, btn) {
    openModal(modal);

    /* let is_webapp = modal.classList.contains("js-modal--webapp") ? true : false;
    if (is_webapp) initWebappModal(modal, btn); */


    let close_btn = modal.querySelector('.js-close-modal');
    if (close_btn) {
        close_btn.addEventListener('click', (e) => {
            e.preventDefault();
            closeModal(modal);
            /* if (is_webapp) clearWebappModal(modal); */
        });
    } else {
        console.log('No close button found for modal, skipping click event listener');
    }


    modal.addEventListener('click', (e) => {
        e.preventDefault();
        if (e.target === modal) {
            closeModal(modal);
            /* if (is_webapp) clearWebappModal(modal); */
        }
    });
}


function openModal(modal) {
    document.querySelector('html').classList.add('--no-scroll');
    modal.classList.add('--active');
}

function closeModal(modal) {
    modal.classList.remove('--active');
    document.querySelector('html').classList.remove('--no-scroll');
}



/* EXAMPLE JS for a dynamic modal */
/* BETER TO USE LIVEWIRE FOR THIS!!!! EXAMPLE WILL BE ADDED IN THE FUTURE */

/* async function initWebappModal(modal, btn) {
    modal.classList.add('--loading');
    let id = btn.getAttribute('data-api-target');
    let data = await fetchWebappDetails(id);
    console.log(data);
    populateWebappModal(modal, data);
    modal.classList.remove('--loading');


    let save_btn = modal.querySelector('.js-save-webapp');
    let del_btn = modal.querySelector('.js-delete-webapp');

    if (save_btn) {
        save_btn.addEventListener('click', async (e) => {
            e.preventDefault();

            // If its already loading return
            if (modal.classList.contains('--loading')) return console.log('Modal not fully loaded yet...');
            if (save_btn.classList.contains('--loading')) return console.log('Already loading...');
            if (save_btn.classList.contains('--disabled')) return console.log('Already processing other action...');

            save_btn.classList.add('--loading');
            del_btn.classList.add('--disabled');

            try {
                await saveWebapp(modal, id);
            } catch (error) {
                console.error('Error saving webapp:', error);
            } finally {
                save_btn.classList.remove('--loading');
                del_btn.classList.remove('--disabled');
            }
        });
    }

    if (del_btn) {
        del_btn.addEventListener('click', async (e) => {
            e.preventDefault();
            if (modal.classList.contains('--loading')) return console.log('Modal not fully loaded yet...');
            if (del_btn.classList.contains('--loading')) return console.log('Already loading...');
            if (del_btn.classList.contains('--disabled')) return console.log('Already processing other action...');

            save_btn.classList.add('--disabled');
            del_btn.classList.add('--loading');

            try {
                await deleteWebapp(modal, id);
            } catch (error) {
                console.error('Error deleting webapp:', error);
            } finally {
                save_btn.classList.remove('--disabled');
                del_btn.classList.remove('--loading');
            }

        });
    }
}

async function fetchWebappDetails(id) {

    console.log(id);

    return fetch(`/api/nodes/${node_id}/webapps/${id}`)
        .then(response => {
            if (response.status === 504) {
                throw new Error('Gateway Timeout');
            }
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            return data.data;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

function populateWebappModal(modal, data) {
    modal.querySelector(`[data-key="name"]`).value = data.name ?? null;
    modal.querySelector(`[data-key="project_name"]`).value = data.meta.project_name ?? null;
    modal.querySelector(`[data-key="type"]`).value = data.type ?? null;
    modal.querySelector(`[data-key="public_address"]`).value = data.meta.public_address ?? null;
    modal.querySelector(`[data-key="description"]`).value = data.meta.description ?? null;
    modal.querySelector(`[data-key="notes"]`).value = data.meta.notes ?? null;
    modal.querySelector(`[data-key="repository_url"]`).value = data.meta.repository_url ?? null;
    modal.querySelector(`[data-key="environment"]`).value = data.meta.environment ?? null;
    modal.querySelector(`[data-key="created_at"]`).value = data.meta.created_at ?? null;
    modal.querySelector(`[data-key="location"]`).value = data.location ?? null;
}

function clearWebappModal(modal) {
    modal.querySelector(`[data-key="name"]`).value = "";
    modal.querySelector(`[data-key="project_name"]`).value = "";
    modal.querySelector(`[data-key="type"]`).value = "";
    modal.querySelector(`[data-key="public_address"]`).value = "";
    modal.querySelector(`[data-key="description"]`).value = "";
    modal.querySelector(`[data-key="notes"]`).value = "";
    modal.querySelector(`[data-key="repository_url"]`).value = "";
    modal.querySelector(`[data-key="environment"]`).value = "";
    modal.querySelector(`[data-key="created_at"]`).value = "";
    modal.querySelector(`[data-key="location"]`).value = "";
}

async function saveWebapp(modal, id) {

    const formData = new FormData();
    let csrf_input = document.querySelector('input[name="_token"]');
    formData.append(csrf_input.getAttribute('name'), csrf_input.value);

    modal.querySelectorAll('[data-key]').forEach(input => {
        formData.append(input.getAttribute('data-key'), input.value);
    });

    return fetch(`/api/nodes/${node_id}/webapps/${id}/save`, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.status === 504) {
            throw new Error('Gateway Timeout');
        }
        return response.json();
    })
    .then(data => {
        if (data.status == "error") {
            throw new Error(data.message);
        }

        toastSuccess('Webapp saved');

        closeModal(modal);
        clearWebappModal(modal);
        window.location.reload();
    })
    .catch(error => {

        toastError('Failed to save webapp');

        throw error;
    });
} */
