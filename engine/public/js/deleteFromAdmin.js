const order = document.querySelector('.order');
order.addEventListener('click', deleteHandler);

function deleteHandler(e) {
    if (e.target.classList.contains('delete')) {
        let id = e.target.getAttribute('data-id');
        let order_id = e.target.getAttribute('data-order-id');
        let method = 'post';
        let url = '/api/deleteFromCart';

        sendRequest(method, url, {id: id, order_id: order_id})
            .then(res => {
                e.target.parentElement.remove();
                const total = document.querySelector('#totalAdmin');
                total.innerText = res.total;
                if (res.count === '0') {
                    order.innerHTML = '<p>Заказ пользователя не содержит товаров</p>';
                }
            })
            .catch(err => {
                console.error("Ошибка!" + err);
            })
    }
}
