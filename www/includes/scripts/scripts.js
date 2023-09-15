/*
 * Drag n Drop
 */
const linkedImages = document.querySelector("#linkedImages");
const registeredImages = document.querySelector("#registeredImages");
let draggedImageId;
const bindImage = (event, imageId) => {
    event.dataTransfer.setData("text", event.target.id);
    draggedImageId = imageId;
}

function allowDrop(e) {
    e.preventDefault();
}

const linkImage = (event, ids) => {
    event.preventDefault();
    let data = event.dataTransfer.getData("text");
    event.target.appendChild(document.getElementById(data));
    const request = new XMLHttpRequest();
    let destination = new URL(window.location.origin.concat("/includes/functions/createRelation.php"));
    destination.searchParams.set("childId", draggedImageId);
    destination.searchParams.set("parentId", ids[0]);
    destination.searchParams.set("childType", ids[1]);
    destination.searchParams.set("parentType", ids[2]);

    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("feedbacks").innerHTML = request.responseText;
        }
    }

    request.open("GET", destination);
    request.send();
}

const unlinkImage = (event, ids) => {
    event.preventDefault();
    let data = event.dataTransfer.getData("text");
    event.target.appendChild(document.getElementById(data));
    const request = new XMLHttpRequest();
    let destination = new URL(window.location.origin.concat("/includes/functions/deleteRelation.php"));
    destination.searchParams.set("childId", draggedImageId);
    destination.searchParams.set("parentId", ids[0]);
    destination.searchParams.set("childType", ids[1]);
    destination.searchParams.set("parentType", ids[2]);

    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("feedbacks").innerHTML = request.responseText;
        }
    }

    request.open("GET", destination);
    request.send();
}