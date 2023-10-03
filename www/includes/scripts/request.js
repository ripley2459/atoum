function putFrom(from, putHere) {
    spinner(putHere);
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

function spinner(putHere) {
    document.getElementById(putHere).innerHTML = "<div class=\"lds-spinner\"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>";
}

// Temporary function before implementing a real form to allow the user to download one or more previews
function setPreview(fromVideo, id = null) {
    const video = document.getElementById(fromVideo);
    const canvas = document.getElementById(fromVideo.concat("-canvas"));

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext("2d").drawImage(video, 0, 0, video.videoWidth, video.videoHeight);

    if (id === null) {
        return;
    }

    const request = new XMLHttpRequest();
    const formData = new FormData();
    const url = new URL(window.location.origin.concat("/includes/functions/createPreview.php"));
    formData.set("id", id);
    formData.set("image", canvas.toDataURL('image/png', 1));
    request.open("POST", url);
    request.send(formData);
}