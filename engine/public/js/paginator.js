let page = 3;
let loading = false;

const catalog2 = document.querySelector('.catalog');
const div = document.createElement('div');
div.classList.add('stop-line');
catalog2.append(div);

document.addEventListener('scroll', fetchMore);

function fetchMore() {
    const point = document.querySelectorAll('.stop-line');
    let stopLine = point[point.length - 1].offsetTop;
    let scroll = window.pageYOffset + window.innerHeight;
    let allowLoad = scroll >= stopLine;
    // console.log(stopLine, scroll, allowLoad);

    if (allowLoad && !loading) {
        let url = `/api/catalog/?page=${page}`;
        let method = 'GET';
        loading = true;
        sendRequest(method, url)
            .then((res) => {
                catalog2.innerHTML += res[1];
                catalog2.append(div);
                page = res[2];
                res[0] ? loading = false : '';
            });
    }
}
