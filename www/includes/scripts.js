/*
 * Window events
 */
const eKeyLeft = new Event("eKeyLeft");
const eKeyRight = new Event("eKeyRight");
const eKeyEscape = new Event("eKeyEscape");

document.onkeydown = function (e) {
    switch (e.keyCode) {
        case 27:
            document.dispatchEvent(eKeyEscape);
            break;
        case 37:
            document.dispatchEvent(eKeyLeft);
            break;
        case 38:
            // alert('up');
            break;
        case 39:
            document.dispatchEvent(eKeyRight);
            break;
        case 40:
            // alert('down');
            break;
    }
};

window.onclick = function (e) {
    if (e.target.classList.contains("modal")) {
        if (openedGallery != null && e.target.classList.contains("gallery")) {
            closeGallery();
            return;
        }
        e.target.classList.remove("open");
    }
}

/*
 * Modal
 */
function toggleModal(id) {
    document.getElementById(id).classList.toggle("open");
}

/*
 * Collapse
 */
function toggleCollapse(id) {
    let elem = document.getElementById(id);
    let content = elem.getElementsByClassName("content")[0];
    elem.classList.toggle("open");
}

/**
 * Applique au formulaire les boîtes cochées.
 * @param name
 * @param formData
 * @param checkboxes
 * @returns {*}
 */
function appendCheckBoxes(name, formData, checkboxes) {
    for (let i = 0, len = checkboxes.length; i < len; i++) {
        if (checkboxes[i].checked) {
            formData.append(name, checkboxes[i].value);
        }
    }

    return formData;
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
let openedGallery;
let autoSlider; // Passage auto des slides
let slideIndex = 0;

function plusSlide(n, g) {
    clearTimeout(autoSlider);
    showSlides(slideIndex += n, g);
}

function currentSlide(s, g) {
    clearTimeout(autoSlider);
    showSlides(slideIndex = s, g);
}

function showSlides(slide, g) {
    let i;
    const gallery = document.getElementById(g);
    const modal = gallery.getElementsByClassName("modal")[0];
    const slides = gallery.getElementsByClassName("slide");
    const thumbnails = gallery.getElementsByClassName("thumbnail");

    if (slide < 0) {
        clearTimeout(autoSlider);
        modal.classList.remove("open");
        openedGallery = null;
        return;
    } else {
        autoSlider = setTimeout(plusSlide, 5000, 1, g);
        modal.classList.add("open");
        openedGallery = g;
    }

    if (slide > slides.length) {
        slideIndex = 1;
    }

    if (slide < 1) {
        slideIndex = slides.length
    }

    for (i = 0; i < slides.length; i++) {
        slides[i].classList.remove("open");
        thumbnails[i].classList.remove("open");
    }

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

function closeGallery() {
    showSlides(-1, openedGallery);
}

document.addEventListener("eKeyEscape", () => {
    if (openedGallery != null) closeGallery();
});
document.addEventListener("eKeyLeft", () => {
    if (openedGallery != null) plusSlide(-1, openedGallery);
});
document.addEventListener("eKeyRight", () => {
    if (openedGallery != null) plusSlide(1, openedGallery);
});

/*
 * Editors
 */
const getContent = (url, resultId, contentId) => {
    const zone = document.getElementById(resultId);
    const request = new XMLHttpRequest();
    let from = new URL(url);
    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) {
            zone.innerHTML = request.responseText;
        }
    };
    from.searchParams.set("contentId", contentId);
    request.open("GET", from);
    request.send();
}

/*
 * Requests
 */
const getFrom = (url, where) => {
    const zone = document.getElementById(where);
    let from = new URL(url);
    sendRequest(from, (request) => {
        zone.innerHTML = request.responseText;
    });
}

const sendRequest = (url, callback = null) => {
    const request = new XMLHttpRequest();
    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) {
            if (callback && (typeof callback == "function")) {
                callback(request);
            }
        }
    };
    request.open("GET", url);
    request.send();
}

/*
 * Dyn data
 */
const takeScreenshot = (fromVideo, videoId = null) => {
    const video = document.getElementById(fromVideo);
    const canvas = document.getElementById(fromVideo.concat("Canvas"));

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext("2d").drawImage(video, 0, 0, video.videoWidth, video.videoHeight);

    if (videoId === null) {
        return;
    }

    const request = new XMLHttpRequest();
    const formData = new FormData();
    const url = new URL(window.location.origin.concat("/includes/functions/videos/createThumbnail.php"));
    url.searchParams.set("videoId", videoId);
    formData.set("image", canvas.toDataURL('image/png', 1));
    request.open("POST", url);
    request.send(formData);
}

const DynDataSearch = (input, type, field) => {
    const zone = document.getElementById(field.concat("DynDataResults"));
    if (input.value.length === 0) {
        zone.innerHTML = "";
        zone.classList.remove("noInput");
        return;
    }

    let url = new URL(window.location.origin.concat("/includes/functions/dynData/search.php"));
    url.searchParams.set("type", type);
    url.searchParams.set("field", field);
    url.searchParams.set("search", input.value);

    getFrom(url, zone.id);
}

const DynDataAddOnClick = (input, type, field) => {
    DynDataAdd(input, type, field);
}

const DynDataAddOnHit = (input, type, field) => {
    if (event.key === "Enter") {
        DynDataAdd(input, type, field);
    }
}

const DynDataAdd = (input, type, field) => {
    const zone = document.getElementById(field.replace("[]", "").concat("DynDataInputs"));
    let newDeleteButton, newField, newDiv;

    newDiv = document.createElement('div');
    newDiv.id = input.replace(/ /g, "_").toLowerCase() + "DynInput";
    newDiv.classList.add("dynInput")

    newField = document.createElement("input");
    newField.type = "text";
    newField.id = input.replace(/ /g, "_").toLowerCase() + "Field";
    newField.setAttribute("value", input); // Bugged ?
    newField.name = field;

    newDeleteButton = document.createElement("button");
    newDeleteButton.innerHTML = "x";
    newDeleteButton.type = "button";
    newDeleteButton.onclick = function () {
        document.getElementById(newDiv.id).remove();
    };

    newDiv.appendChild(newField);
    newDiv.appendChild(newDeleteButton);
    zone.appendChild(newDiv);
}

const DynDataRemove = (field) => {
    document.getElementById(field).remove();
}

const DynDataSubmit = (formId, dataId, type, sections) => {
    const request = new XMLHttpRequest();
    const form = document.getElementById(formId.concat(dataId));
    let formData = new FormData(form);
    let url = new URL(window.location.origin.concat("/includes/functions/dynData/apply.php"));

    formData.append("id", dataId);
    formData.append("type", type);
    formData.set("name", form.elements["name"].value);

    sections.forEach(s => {
        if (typeof form.elements[s] !== 'undefined') {
            formData.append("sections[]", s);
            formData = appendCheckBoxes(s, formData, form.elements[s]);
        }
    })

    request.onload = function () {
        document.getElementById("DynDataForm".concat(dataId)).innerHTML = this.responseText;
        window.location.reload();
    }

    request.open("POST", url);
    request.send(formData);
}