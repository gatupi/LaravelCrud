function addEventListenersToModals() {
    let modals = findModals();
    for (let m of modals) { // iterar modais adicionando event listener
        let closeButton = m.querySelector('.cms-modal-close');
        closeButton.addEventListener('click', function () {
            m.classList.toggle('cms-closed-modal');
            removeModalContent(m);
        });
    }
}

function findModals() {
    return document.getElementsByClassName('cms-modal');
}

function removeModalContent(modal) {
    modal.querySelector('.cms-modal-content').remove();
}

function createModalContent() {
    let modalContent = document.createElement('div');
    modalContent.classList.add('cms-modal-content');
    return modalContent;
}

function openModal(modal) {
    modal.classList.toggle('cms-closed-modal');
    modal.querySelector('.cms-modal-box').append(createModalContent());
}