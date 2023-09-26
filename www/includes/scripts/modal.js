let modal = null;
let url = null;
let edit = null;

// Events

document.addEventListener("KeyEscape", () => {
    if (edit && modal) closeEdit(modal);
    else if (modal) close(modal);
});

window.onclick = function (e) {
    if (e.target.classList.contains("modal")) {
        if (edit && modal) closeEdit(modal);
        else if (modal) close(modal);
    }
}

// Common functions

function open(id) {
    modal = id;
    url = window.location;
    if (!document.getElementById(id).classList.contains("open")) document.getElementById(id).classList.add("open");
}

function close() {
    document.getElementById(modal).classList.remove("open");
    modal = null;
    url = null;
}

// Edit modal

function openEdit(id) {
    edit = id;
    sendRequest(window.location.origin.concat("/includes/functions/getEdit.php?id=" + id), (request) => {
        document.getElementById("edit").innerHTML = request.responseText;
        open("edit-modal-" + id);
        atoumEvents.addEventListener("onUpdatePagination", refreshEdit);
        atoumEvents.addEventListener("onURLModified", refreshEdit);
        atoumEvents.removeEventListener("onURLModified", getUploads);
        refreshEdit(id);
    });
}

function closeEdit() {
    atoumEvents.removeEventListener("onUpdatePagination", refreshEdit);
    atoumEvents.addEventListener("onURLModified", getUploads);

    document.getElementById("edit-modal-" + edit).classList.remove("open");
    modal = null;
    edit = null;
}

function refreshEdit() {
    let nl = new URL(window.location.origin.concat("/includes/functions/getImagesNonLinked.php?id=" + edit));
    bindParams(nl);
    putFrom(nl, "registeredImages");

    let il = new URL(window.location.origin.concat("/includes/functions/getImagesLinked.php?id=" + edit));
    bindParams(il);
    putFrom(il, "linkedImages");

    updatePagination("pagination-edit");
}

function applyEdit(sections) {
    const form = document.getElementById("edit-modal-" + edit);
    const destination = new URL(window.location.origin.concat("/includes/functions/edit.php"));
    const request = new XMLHttpRequest();
    let formData = new FormData(form);

    formData.set("id", edit);
    formData.set("name", form.elements["name-" + edit].value);
    formData.set("date", form.elements["date-" + edit].value);
    formData.set("views", form.elements["views-" + edit].value);
    sections.forEach(s => {
        const cc = s.replace("-" + edit, "");
        formData.append("sections[]", cc.replace("[]", ""));
        const inputs = document.querySelectorAll('input[name=\"' + s + '\"]');
        inputs.forEach(function (input) {
            formData.append(cc, input.value);
        });
    })

    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("feedbacks").innerHTML = request.responseText;
        }
    };

    request.open("POST", destination);
    request.send(formData);
}