const KeyLeft = new Event("KeyLeft");
const KeyRight = new Event("KeyRight");
const KeyEscape = new Event("KeyEscape");
const KeyUp = new Event("KeyUp");
const KeyDown = new Event("KeyDown");

document.onkeydown = function (e) {
    switch (e.keyCode) {
        case 27:
            document.dispatchEvent(KeyEscape);
            break;
        case 37:
            document.dispatchEvent(KeyLeft);
            break;
        case 38:
            document.dispatchEvent(KeyUp);
            break;
        case 39:
            document.dispatchEvent(KeyRight);
            break;
        case 40:
            document.dispatchEvent(KeyDown);
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
            if (event.callbacks.length === 0) delete this.events[eventName];
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
        if (index > -1) this.callbacks.splice(index, 1);
    }

    fire(data) {
        const callbacks = this.callbacks.slice(0);
        callbacks.forEach((callback) => callback(data));
    }
}

const atoumEvents = new AtoumDispatcher();