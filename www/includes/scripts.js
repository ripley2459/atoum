/*
 * Modal
 */
function toggleModal(id) {
    document.getElementById(id).classList.toggle("open");
}

window.onclick = function (e) {
    if (e.target.classList.contains("modal")) {
        e.target.classList.remove("open");
    }
    if (e.target.classList.contains("slideshow")) {
        e.target.parentElement.classList.remove("open");
    }
}

/*
 * Collapse
 */
function toggleCollapse(id) {
    document.getElementById(id).classList.toggle("open");
}

/*
 * Search options
 */
const toggleURLParam = (name, value, callback = null) => {
    let newURL = new URL(document.URL);
    let sP = newURL.searchParams;
    if (sP.has(name)) {
        sP.delete(name);
    } else {
        sP.set(name, value);
    }
    window.history.replaceState({id: "100"}, name, newURL);
    if (callback && (typeof callback == "function")) callback();
}

const toggleValueURLParam = (name, newValue, callback = null) => {
    let newURL = new URL(document.URL);
    let sP = newURL.searchParams;
    if (sP.has(name)) {
        if (parseInt(sP.get(name)) === newValue) sP.delete(name);
        else sP.set(name, newValue);
    } else {
        sP.set(name, newValue);
    }
    window.history.replaceState({id: "100"}, name, newURL);
    if (callback && (typeof callback == "function")) callback();
}

const setURLParam = (name, value, callback = null) => {
    let newURL = new URL(document.URL);
    newURL.searchParams.set(name, value);
    window.history.replaceState({id: "100"}, name, newURL);
    if (callback && (typeof callback == "function")) callback();
}

const getPagination = (zone) => {

}

const bindPagination = (params, from) => {
    if (params.has("type")) from.searchParams.set("type", params.get("type"));
    if (params.has("status")) from.searchParams.set("status", params.get("status"));
    if (params.has("orderBy")) from.searchParams.set("orderBy", params.get("orderBy"));
    if (params.has("limit")) from.searchParams.set("limit", params.get("limit"));
    if (params.has("currentPage")) from.searchParams.set("currentPage", params.get("currentPage"));
    if (params.has("searchFor")) from.searchParams.set("searchFor", params.get("searchFor"));
    if (params.has("displayContent")) from.searchParams.set("displayContent", params.get("displayContent"));
}

const updatePagination = () => {

}

/*
 * Drag n Drop
 */
function allowDrop(e) {
    e.preventDefault();
}

/*
 * Grids
 */
function changeGridColumnsAmount(id, value) {
    document.getElementById(id).style.columnCount = value;
}

/*
 * Gallery
 */
function plusSlide(n, g) {
    showSlides(slideIndex += n, g);
}

function currentSlide(s, g) {
    showSlides(slideIndex = s, g);
}

function showSlides(n, g) {
    let i;
    const gallery = document.getElementById(g);
    const modal = gallery.getElementsByClassName("modal");
    const slides = gallery.getElementsByClassName("slide");
    const thumbnails = gallery.getElementsByClassName("thumbnail");
    // const slideshowProgress = gallery.getElementById("slideshow-progress");

    modal[0].classList.add("open");

    if (n > slides.length) {
        slideIndex = 1;
    }

    if (n < 1) {
        slideIndex = slides.length
    }

    for (i = 0; i < slides.length; i++) {
        slides[i].classList.remove("open");
        thumbnails[i].classList.remove("open");
    }

    // slideshowProgress.textContent = slideIndex + "/" + slides.length;
    slides[slideIndex - 1].classList.add("open");

    function clamp(x) {
        if (x < 0) {
            x = 0
        } else if (x > slides.length) {
            x = slides.length;
        }
        return x;
    }

    thumbnails[clamp(slideIndex - 3)].classList.add("open");
    thumbnails[clamp(slideIndex - 2)].classList.add("open");
    thumbnails[clamp(slideIndex - 1)].classList.add("open");
    thumbnails[clamp(slideIndex + 0)].classList.add("open");
    thumbnails[clamp(slideIndex + 1)].classList.add("open");
}