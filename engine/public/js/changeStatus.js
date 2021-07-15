document.querySelector('.change-status-button').addEventListener('click', changeStatusHandler);
const responseField = document.querySelector('#status-response');

function changeStatusHandler(e) {
    let method = 'post';
    let url = '/admin/changeStatus';
    let status = document.querySelector('#status').value;
    let id = e.target.getAttribute('data-id');

    sendRequest(method, url, {status: status, id: id})
        .then(res => {
            if (res.status === 'ok') {
                responseField.innerText = 'Статус заказа изменён';
            } else if (res.status === 'error') {
                responseField.innerText = 'Ошибка. Не удалось изменить заказ';
            }
        })
        .catch(err => {
            responseField.innerText = "Ошибка! " + err;
        });
}
