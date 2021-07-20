const cart = document.querySelector('.cart');
cart.addEventListener('click', deleteFromCartHandler);
const clear = document.querySelector('#clear-cart');
clear.addEventListener('click', clearCartHandler);

function deleteFromCartHandler(e) {
    if (e.target.classList.contains('delete')) {
        let id = e.target.getAttribute('data-id');
        let method = 'post';
        let url = '/api/deleteFromCart';

        sendRequest(method, url, {id: id})
            .then((res) => {
                const counter = document.querySelector('#count');
                const total = document.querySelector('#totalCart');
                const cartGood = e.target.parentElement;

                counter.innerText = res.count;
                total.innerText = res.total;
                cartGood.remove();

                if (res.count === '0') {
                    cart.innerHTML = '';
                    cart.append(document.createElement('h2').innerText = 'Корзина');
                    cart.append(document.createElement('p').innerText = 'Корзина пуста');
                }
            })
            .catch((err) => {
                console.error("Ошибка!" + err);
            });
    }
}

function clearCartHandler() {
    cart.innerHTML = '';
    const cartHeader = document.createElement('h2');
    const cartEmpty = document.createElement('p');
    cartHeader.innerText = 'Корзина';
    cartEmpty.innerText = 'Корзина пуста';
    cart.append(cartHeader);
    cart.append(cartEmpty);

    let method = 'post';
    let url = '/api/clearCart';
    sendRequest(method, url)
        .then(res => {
            const counter = document.querySelector('#count');
            counter.innerText = res.count;
        })
        .catch(err => {
            console.error("Ошибка! " + err);
        });
}
