window.onload = function () {

    var urlPath = window.location.pathname;

    switch (urlPath) {
        case '/product/create':
            console.log(`está na rota: ${urlPath}`);
            addEventListenersToModals();
            break;
        default:
            console.log('rota desconhecida');
    }
}