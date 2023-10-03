/*
 * Gallery settings
 */


function linkImage(button, imageId, ids) {
    applyImage(imageId, ids, new URL(window.location.origin.concat("/includes/functions/createRelation.php")));
    button.onclick = () => unlinkImage(button, imageId, ids);
    const linkedImages = document.querySelector("#linkedImages");
    const registeredImages = document.querySelector("#registeredImages");
    linkedImages.appendChild(button);
    registeredImages.removeChild(button);
}

function unlinkImage(button, imageId, ids) {
    applyImage(imageId, ids, new URL(window.location.origin.concat("/includes/functions/deleteRelation.php")));
    button.onclick = () => linkImage(button, imageId, ids);
    const linkedImages = document.querySelector("#linkedImages");
    const registeredImages = document.querySelector("#registeredImages");
    registeredImages.appendChild(button);
    linkedImages.removeChild(button);
}

function applyImage(id, ids, destination) {
    const request = new XMLHttpRequest();
    destination.searchParams.set("childId", id);
    destination.searchParams.set("parentId", ids[0]);
    destination.searchParams.set("childType", ids[1]);
    destination.searchParams.set("parentType", ids[2]);

    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) document.getElementById("feedbacks").innerHTML = request.responseText;
    }

    request.open("GET", destination);
    request.send();
}

function accordion(id) {
    const accordion = document.getElementById(id + "-button");
    const panel = document.getElementById(id + "-panel");
    if (accordion.classList.contains("open")) {
        accordion.classList.remove("open");
        panel.style.maxHeight = "0px";
    } else {
        accordion.classList.add("open");
        panel.style.maxHeight = "none";
    }
}