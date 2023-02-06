/*
 * Modal
 */
function toggleModal(id) {
    console.log(id);
    document.getElementById(id).classList.toggle("open");
}

window.onclick = function (e) {
    if (e.target.classList.contains("modal")) {
        e.target.classList.remove("open");
    }
}