const moreButton = document.querySelector('#more');
moreButton.addEventListener('click', getPageHandler);

function getPageHandler(e) {
    let page = e.target.getAttribute('data-page');
    let url = `/api/catalog/?page=${page}`;
    let method = 'GET';
    sendRequest(method, url)
        .then((res) => {
            let catalog = document.querySelector('.catalog');
            catalog.innerHTML += res[0];
            e.target.setAttribute('data-page', res[1]);
        });
}
