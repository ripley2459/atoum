const urlParams = ["display", "type", "status", "order", "limit", "page", "show", "display", "search"];

function bindParams(url) {
    const params = new URLSearchParams(new URL(document.URL).toString());
    for (let x of urlParams) {
        if (params.has(x) && params.get(x)) url.searchParams.set(x, params.get(x));
    }
}

function toggleBetween(name, valueA, valueB) {
    let sP = new URL(document.URL).searchParams;
    if (sP.get(name) === valueA) set(name, valueB);
    else set(name, valueA);
}

function toggle(name, value) {
    let sP = new URL(document.URL).searchParams;
    if (sP.get(name) === value) remove(name);
    else set(name, value);
}

function set(name, value) {
    if (!value) {
        remove(name);
        return;
    }

    let newURL = new URL(document.URL);
    newURL.searchParams.set(name, value);
    window.history.replaceState({id: "100"}, name, newURL);
    atoumEvents.dispatchEvent("onURLModified");
}

function remove(name) {
    let newURL = new URL(document.URL);
    if (newURL.searchParams.get(name)) newURL.searchParams.delete(name);
    window.history.replaceState({id: "100"}, name, newURL);
    atoumEvents.dispatchEvent("onURLModified");
}