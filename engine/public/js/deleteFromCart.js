const cart = document.querySelector('.cart');
cart.addEventListener('click', deleteFromCartHandler);
const clear = document.querySelector('#clear-cart');
clear.addEventListener('click', clearCartHandler);

function deleteFromCartHandler(e) {
    if (e.target.classList.contains('delete')) {
        let id = e.target.getAttribute('data-id');
        let method = 'post';
        let url = '/api/deleteFromCart';
        const cartGood = e.target.parentElement;
        cartGood.parentNode.removeChild(cartGood);
        sendRequest(method, url, {id: id})
            .then((res) => {
                const counter = document.querySelector('#count');
                const total = document.querySelector('#total');
                counter.innerText = res.count;
                total.innerText = res.total;

                if (res.count === '0') {
                    const pTotal = document.querySelector('.total');
                    pTotal.parentNode.removeChild(pTotal);
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
