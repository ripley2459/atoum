function updatePagination(id) {
    const url = new URL(document.URL);
    const zone = document.getElementById(id);
    zone.innerHTML = '';

    let previousPage = 0;
    let actualPage = 1;
    let nextPage = 2;

    if (url.searchParams.has('page')) {
        actualPage = Number(url.searchParams.get('page'));
        previousPage = Number(actualPage) - Number(1);
        nextPage = Number(actualPage) + Number(1);
    }

    let previousButton = document.createElement('button');
    previousButton.innerHTML = '◄';
    let actualButton = document.createElement('button');
    actualButton.innerHTML = actualPage.toString();
    let nextButton = document.createElement('button');
    nextButton.innerHTML = '►';

    if (actualPage !== 1) {
        previousButton.onclick = function () {
            set('page', previousPage);
            atoumEvents.dispatchEvent("onUpdatePagination");
        }
    }

    nextButton.onclick = function () {
        set('page', nextPage);
        atoumEvents.dispatchEvent("onUpdatePagination");
    }

    zone.appendChild(previousButton);
    zone.append(' ');
    zone.appendChild(actualButton);
    zone.append(' ');
    zone.appendChild(nextButton);
}