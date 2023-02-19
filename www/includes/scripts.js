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
}

/*
 * Search options
 */
const setType = (newType, callback = null) => {
    let newURL = new URL(document.URL);
    let searchParams = newURL.searchParams;
    if (searchParams.has("type")) {
        searchParams.delete("type");
    } else {
        searchParams.set("type", newType);
    }
    window.history.replaceState({id: "100"}, "type", newURL);
    if (callback && (typeof callback == "function")) callback();
}

const setStatus = (newStatus, callback = null) => {
    let newURL = new URL(document.URL);
    let searchParams = newURL.searchParams;
    if (searchParams.has("status")) {
        searchParams.delete("status");
    } else {
        searchParams.set("status", newStatus);
    }
    window.history.replaceState({id: "100"}, "status", newURL);
    if (callback && (typeof callback == "function")) callback();
}

const setOrderBy = (newOrderBy, callback = null) => {
    let newURL = new URL(document.URL);
    newURL.searchParams.set("orderBy", newOrderBy);
    window.history.replaceState({id: "100"}, "orderBy", newURL);
    if (callback && (typeof callback == "function")) callback();
}

const setLimit = (newLimit, callback = null) => {
    let newURL = new URL(document.URL);
    newURL.searchParams.set("limit", newLimit);
    newURL.searchParams.set("currentPage", "1");
    window.history.replaceState({id: "100"}, "limit", newURL);
    if (callback && (typeof callback == "function")) callback();
}

const setCurrentPage = (newCurrentPage, callback = null) => {
    let newURL = new URL(document.URL);
    newURL.searchParams.set("currentPage", newCurrentPage);
    window.history.replaceState({id: "100"}, "currentPage", newURL);
    if (callback && (typeof callback == "function")) callback();
}

const setSearchFor = (newSearchFor, callback = null) => {
    let newURL = new URL(document.URL);
    newURL.searchParams.delete("searchFor");
    newURL.searchParams.set("searchFor", newSearchFor);
    window.history.replaceState({id: "100"}, "searchFor", newURL);
    if (callback && (typeof callback == "function")) callback();
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