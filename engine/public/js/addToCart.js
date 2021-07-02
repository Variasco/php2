const catalog = document.querySelector('.catalog');
catalog.addEventListener('click', addToCartHandler)

function addToCartHandler(e) {
    if (e.target.classList.contains('buy')) {
        let id = e.target.getAttribute('data-id');
        let method = 'post';
        let url = '/api/addToCart';
        sendRequest(method, url, {id: id})
            .then((res) => {
                const counter = document.querySelector('#count');
                counter.innerText = res.count;
            })
            .catch((err) => {
                console.error("Ошибка!" + err);
            });
    }
}
