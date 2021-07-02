function sendRequest(method, url, body = undefined) {
    const headers = {
        'Content-Type': 'application/json;charset=utf-8'
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
