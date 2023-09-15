function putFrom(from, putHere) {
    sendRequest(new URL(from), (request) => {
        document.getElementById(putHere).innerHTML = request.responseText;
    });
}

function sendRequest(from, callback = null) {
    const request = new XMLHttpRequest();
    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) {
            if (callback != null && (typeof callback == "function")) callback(request);
        }
    };

    request.open("GET", from);
    request.send();
}