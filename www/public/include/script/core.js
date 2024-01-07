const func = (func) => {
    return window.location.origin.concat("/app/entry.php?function=").concat(func);
}

/* ==================================================
 * AJAX
 */

const putFrom = (from, putHere) => {
    sendRequest(new URL(from), (request) => {
        document.getElementById(putHere).innerHTML = request.responseText;
    });
}

/**
 * Sends an XMLHttpRequest to the specified URL.
 * @param {string} from - The URL to send the request to.
 * @param {function|array|null} callback - A function or an array of functions to be called when the request completes successfully. Each function in the array is called with the XMLHttpRequest object as its argument.
 */
const sendRequest = (from, callback = null) => {
    const request = new XMLHttpRequest();
    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) {
            if (Array.isArray(callback)) {
                callback.forEach(cb => {
                    if (typeof cb === "function")
                        cb(request);
                });
            } else if (callback != null && typeof callback === "function")
                callback(request);
        }
    };

    request.open("GET", from);
    request.send();
}

/* ==================================================
 * Event
 */

const KEY_LEFT = new Event("KeyLeft");
const KEY_RIGHT = new Event("KeyRight");
const KEY_UP = new Event("KeyUp");
const KEY_DOWN = new Event("KeyDown");
const KEY_ESCAPE = new Event("KeyEscape");

document.onkeydown = function (e) {
    switch (e.keyCode) {
        case 27:
            document.dispatchEvent(KEY_ESCAPE);
            break;
        case 37:
            document.dispatchEvent(KEY_LEFT);
            break;
        case 38:
            document.dispatchEvent(KEY_UP);
            break;
        case 39:
            document.dispatchEvent(KEY_RIGHT);
            break;
        case 40:
            document.dispatchEvent(KEY_DOWN);
            break;
    }
};

class AtoumDispatcher {
    constructor() {
        this.events = {};
    }

    dispatchEvent(eventName, data) {
        const event = this.events[eventName];
        if (event) {
            event.fire(data);
        }
    }

    addEventListener(eventName, callback) {
        let event = this.events[eventName];
        if (!event) {
            event = new AtoumEvent(eventName);
            this.events[eventName] = event;
        }

        event.registerCallback(callback);
    }

    removeEventListener(eventName, callback) {
        const event = this.events[eventName];
        if (event && event.callbacks.indexOf(callback) > -1) {
            event.unregisterCallback(callback);
            if (event.callbacks.length === 0)
                delete this.events[eventName];
        }
    }
}

class AtoumEvent {
    constructor(eventName) {
        this.eventName = eventName;
        this.callbacks = [];
    }

    registerCallback(callback) {
        this.callbacks.push(callback);
    }

    unregisterCallback(callback) {
        const index = this.callbacks.indexOf(callback);
        if (index > -1)
            this.callbacks.splice(index, 1);
    }

    fire(data) {
        const callbacks = this.callbacks.slice(0);
        callbacks.forEach((callback) => callback(data));
    }
}

const ATOUM_EVENTS = new AtoumDispatcher();

/* ==================================================
 * URL Manipulation
 */

function toggleBetweenParams(name, valueA, valueB) {
    let sP = new URL(document.URL).searchParams;
    if (sP.get(name) === valueA)
        setParam(name, valueB);
    else setParam(name, valueA);
}

function toggleParam(name, value) {
    let sP = new URL(document.URL).searchParams;
    if (sP.get(name) == value)
        removeParam(name);
    else setParam(name, value);
}

function setParam(name, value) {
    if (!value) {
        removeParam(name);
        return;
    }

    let newURL = new URL(document.URL);
    newURL.searchParams.set(name, value);
    window.history.replaceState({id: "100"}, name, newURL);
    ATOUM_EVENTS.dispatchEvent("onURLModified");
}

function setParams(name, array) {
    if (array.length <= 0) {
        setParam(name, null);
        return;
    }

    let value = encodeURIComponent(JSON.stringify(array));
    setParam(name, value);
}

function removeParam(name) {
    let newURL = new URL(document.URL);
    if (newURL.searchParams.get(name))
        newURL.searchParams.delete(name);
    window.history.replaceState({id: "100"}, name, newURL);
    ATOUM_EVENTS.dispatchEvent("onURLModified");
}

/* ==================================================
 * Accordion & collapse
 */

function toggleCollapse(button) {
    button.classList.toggle("active");
    const data = document.getElementById(button.id.concat("-data"));
    data.classList.toggle("active");
    if (data.style.maxHeight)
        data.style.maxHeight = null;
    else data.style.maxHeight = data.scrollHeight + "px";
}

/* ==================================================
 * Pagination
 */

const updatePagination = () => {
    const searchParams = new URLSearchParams(window.location.search);
    const zone = document.getElementById("pagination");
    zone.innerHTML = "";

    let previousPage = 0;
    let actualPage = 1;
    let nextPage = 2;

    if (searchParams.has("offset")) {
        actualPage = Number(searchParams.get("offset"));
        previousPage = Number(actualPage) - Number(1);
        nextPage = Number(actualPage) + Number(1);
    }

    let previousButton = document.createElement("button");
    previousButton.innerHTML = "◄";
    let actualButton = document.createElement("button");
    actualButton.innerHTML = actualPage.toString();
    let nextButton = document.createElement("button");
    nextButton.innerHTML = "►";

    if (actualPage !== 1) {
        previousButton.onclick = function () {
            setParam("offset", previousPage);
            //ATOUM_EVENTS.dispatchEvent("onUpdatePagination");
        }
    }

    nextButton.onclick = function () {
        setParam("offset", nextPage);
    }

    zone.appendChild(previousButton);
    zone.append(" ");
    zone.appendChild(actualButton);
    zone.append(" ");
    zone.appendChild(nextButton);
}

const saveDB = (from, putHere) => {
    let destination = new URL(func('db/saveDB'));
    putFrom(destination, 'notifications');
}