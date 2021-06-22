function sendRequest(method, url, body = undefined) {
    const headers = {
        "Content-Type": 'application/json'
    };

    return fetch(url, {
        method: method,
        body: JSON.stringify(body),
        headers: headers
    })
        .then(res => {
            if (res.ok) {
                return res.json();
            }
            return res.json().then(error => {
                const err = new Error('Something went wrong');
                err.data = error;
                throw err;
            });
        });
}

const moreButton = document.querySelector('#more');
moreButton.addEventListener('click', (event) => {
    let url = event.target.attributes.href;
    let method = 'GET';
    sendRequest(method, url)
        .then((res) => {
            // console.log(res);
            console.log(this);
        });
});
