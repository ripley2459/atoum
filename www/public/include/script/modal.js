/* ==================================================
 * Modals
 */

let modal = null; // The actual opened modal
let url = null; // The URL before the modal was opened (in case of URL modifications)
let edit = null; // The Content editor modal

document.addEventListener("KeyEscape", () => {
    if (edit && modal)
        closeEdit(modal);
    else if (modal)
        close(modal);
});

window.onclick = function (e) {
    if (e.target.classList.contains("modal")) {
        if (edit && modal)
            closeEdit(modal);
        else if (modal)
            close(modal);
    }
}

function open(id) {
    modal = id;
    url = window.location;
    if (!document.getElementById(id).classList.contains("open"))
        document.getElementById(id).classList.add("open");
}

function close() {
    document.getElementById(modal).classList.remove("open");
    modal = null;
    url = null;
}