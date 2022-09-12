/*===============================================================================================*\

	Diaporama.

\*===============================================================================================*/

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    let v;
    let slides = document.getElementsByClassName("slide");
    let thumbnails = document.getElementsByClassName("thumbnail");
    let slideshowProgress = document.getElementById("slideshow-progress");

    // Boucler quand on arrive aux extrémités.
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length
    }

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slideshowProgress.textContent = slideIndex + '/' + slides.length;
    slides[slideIndex - 1].style.display = "block";

    // Thumbnails
    for (i = 0; i < slides.length; i++) {
        thumbnails[i].classList.remove("active");
    }

    function clamp(x) {
        if (x < 0) {
            x = 0
        } else if (x > slides.length) {
            x = slides.length;
        }
        return x;
    }

    thumbnails[clamp(slideIndex - 3)].classList.add("active");
    thumbnails[clamp(slideIndex - 2)].classList.add("active");
    thumbnails[clamp(slideIndex - 1)].classList.add("active");
    thumbnails[clamp(slideIndex)].classList.add("active");
    thumbnails[clamp(slideIndex + 1)].classList.add("active");
}

/**
 * Déplace une image dans les favoris.
 * @param {string} image à ajouter dans les favoris.
 */
function setFavorite(image, button) {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
        button.setAttribute('onclick', 'removeFavorite(\'' + image + '\',this)');
        button.innerHTML = "<i class=\"fa fa-star\"></i>";
    }

    xhttp.open("GET", "../includes/functions/galeries/setFavorite.php?image=" + image);
    xhttp.send();
}

/**
 * Supprime une image des favoris.
 * @param {string} image à supprimer dans les favoris.
 */
function removeFavorite(image, button) {
    const xhttp = new XMLHttpRequest();
    console.log("ok");
    xhttp.onload = function () {
        console.log(image);
        button.setAttribute('onclick', 'setFavorite(\'' + image + '\',this)');
        button.innerHTML = "<i class=\"fa fa-star-o\"></i>";
    }

    xhttp.open("GET", "../includes/functions/galeries/removeFavorite.php?image=" + image);
    xhttp.send();
}

/*===============================================================================================*\

	Personnes

\*===============================================================================================*/

/**
 * Affiche toutes les personnes enregistrées dans la base de données.
 */
function getAllPersons() {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
        document.getElementById("persons").innerHTML = this.responseText;
    }

    xhttp.open("GET", "../includes/functions/persons/getAllPersons.php");
    xhttp.send();
}

/**
 * Affiche un formulaire pour éditer une personne.
 * @param {string} id
 */
function openPersonSettings(id) {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
        document.getElementById(id).innerHTML = this.responseText;
    }

    xhttp.open("GET", "../includes/functions/persons/getPersonSettings.php?person=" + id);
    xhttp.send();

    toggleVisibility(id);
}

/**
 * Ajoute dans la base de donnée une nouvelle personne et actualise le tableau.
 */
function registerNewPerson() {
    const xhttp = new XMLHttpRequest();

    let f = document.getElementById("addNewPerson");
    let fData = new FormData(f);

    fData.append("name", f.elements["name"].value);

    xhttp.onload = function () {
        getAllPersons();
    }

    xhttp.open("POST", "../includes/functions/persons/registerNewPerson.php");
    xhttp.send(fData);
}

/**
 * Modifie une personne.
 * @param {int} id
 */
function modifyThisPerson(id) {
    const xhttp = new XMLHttpRequest();

    let f = document.getElementById("updatePerson" + id);
    let fData = new FormData(f);

    fData.append("name", f.elements["name"].value);

    let tags = f.elements["tags[]"];
    for (let i = 0, len = tags.length; i < len; i++) {
        if (tags[i].checked) {
            fData.append("tags[]", tags[i].value);
        }
    }

    xhttp.onload = function () {
        getAllPersons();
        openPersonSettings(id);
    }

    xhttp.open("POST", "../includes/functions/persons/modifyThisPerson.php?person=" + id);
    xhttp.send(fData);
}

/**
 * Supprime de la base de donnée la personne et actualise le tableau.
 * @param {int} id de la personne
 */
function unregisterThisPerson(id) {
    if (window.confirm("Do you really want to unregister this person? ")) {
        const xhttp = new XMLHttpRequest();

        xhttp.onload = function () {
            getAllPersons();
        }

        xhttp.open("GET", "../includes/functions/persons/unregisterThisPerson.php?person=" + id);
        xhttp.send();
    }
}

/*===============================================================================================*\

	Films

\*===============================================================================================*/

/**
 * Affiche tous les films enregistrés dans la base de données.
 */
function getAllMovies() {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
        document.getElementById("movies").innerHTML = this.responseText;
    }

    xhttp.open("GET", "../includes/functions/movies/getAllMovies.php");
    xhttp.send();
}

function updateMovie(id) {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
        document.getElementById(id + "_row").innerHTML = this.responseText;
    }

    xhttp.open("GET", "../includes/functions/movies/updateThisMovie.php?movie=" + id);
    xhttp.send();
}

/**
 * Affiche un formulaire pour éditer un film.
 * @param {string} id
 */
function openMovieSettings(id) {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
        document.getElementById(id).innerHTML = this.responseText;
    }

    xhttp.open("GET", "../includes/functions/movies/getMovieSettings.php?movie=" + id);
    xhttp.send();

    toggleVisibility(id);
}

/**
 * Modifie un film.
 * @param {int} id
 */
function modifyThisMovie(id) {
    const xhttp = new XMLHttpRequest();

    let f = document.getElementById("updateMovie" + id);
    let fData = new FormData(f);

    fData.append("name", f.elements["name"].value);

    let tags = f.elements["tags[]"];
    for (let i = 0, len = tags.length; i < len; i++) {
        if (tags[i].checked) {
            fData.append("tags[]", tags[i].value);
        }
    }

    xhttp.onload = function () {
        getAllMovies();
        openMovieSettings(id);
    }

    xhttp.open("POST", "../includes/functions/movies/modifyThisMovie.php?movie=" + id);
    xhttp.send(fData);
}

/**
 * Supprime de la base de donnée le film et actualise le tableau.
 * @param {int} id de la moviene
 */
function unregisterThisMovie(id) {
    if (window.confirm("Do you really want to unregister this movie? ")) {
        const xhttp = new XMLHttpRequest();

        xhttp.onload = function () {
            getAllMovies();
        }

        xhttp.open("GET", "../includes/functions/movies/unregisterThisMovie.php?movie=" + id);
        xhttp.send();
    }
}

/**
 * Enregistre un nouveau film.
 */
function registerNewMovie() {
    const xhttp = new XMLHttpRequest();

    let f = document.getElementById("registerNewMovie");
    let fData = new FormData(f);

    fData.append("name", f.elements["name"].value);

    let tags = f.elements["tags[]"];
    for (let i = 0, len = tags.length; i < len; i++) {
        if (tags[i].checked) {
            fData.append("tags[]", tags[i].value);
        }
    }

    let persons = f.elements["persons[]"];
    for (let i = 0, len = persons.length; i < len; i++) {
        if (persons[i].checked) {
            fData.append("persons[]", persons[i].value);
        }
    }

    fData.append("preview", f.elements["preview"].value);
    fData.append("movie", f.elements["movie"].value);

    xhttp.onload = function () {
        getAllMovies();
    }

    xhttp.open("POST", "../includes/functions/movies/registerNewMovie.php");
    xhttp.send(fData);
}

/**
 * Enregistre plusieurs films.
 */
function bulkUpload() {
    const xhttp = new XMLHttpRequest();

    let f = document.getElementById("registerNewMovie");
    let fData = new FormData(f);

    let tags = f.elements["tags[]"];
    for (let i = 0, len = tags.length; i < len; i++) {
        if (tags[i].checked) {
            fData.append("tags[]", tags[i].value);
        }
    }

    let persons = f.elements["persons[]"];
    for (let i = 0, len = persons.length; i < len; i++) {
        if (persons[i].checked) {
            fData.append("persons[]", persons[i].value);
        }
    }

    xhttp.onload = function () {
        getAllMovies();
    }

    xhttp.open("POST", "../includes/functions/movies/bulkUpload.php");
    xhttp.send(fData);
}

/**
 * Ajoute dans la base de donnée une nouvelle personne et actualise le tableau.
 */
function applyPersonOnContent() {
    const xhttp = new XMLHttpRequest();

    let f = document.getElementById("addRelatedPerson");
    let fData = new FormData(f);

    fData.append("name", f.elements["name"].value);

    xhttp.onload = function () {
        //getAllPersons();
    }

    xhttp.open("POST", "../includes/functions/persons/applyPersonOnContent.php");
    xhttp.send(fData);
}

/*===============================================================================================*\

	Galeries

\*===============================================================================================*/

/**
 * Affiche toutes les galeries enregistrées dans la base de données.
 */
function getAllGaleries() {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
        document.getElementById("galeries").innerHTML = this.responseText;
    }

    xhttp.open("GET", "../includes/functions/galeries/getAllGaleries.php");
    xhttp.send();
}

/**
 * Affiche un formulaire pour éditer une galerie.
 * @param {string} id
 */
function openGalerySettings(id) {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
        document.getElementById(id).innerHTML = this.responseText;
    }

    xhttp.open("GET", "../includes/functions/galeries/getGalerySettings.php?galery=" + id);
    xhttp.send();

    toggleVisibility(id);
}

/**
 * Ajoute dans la base de donnée une nouvelle galerie et actualise le tableau.
 */
function registerNewGalery() {
    const xhttp = new XMLHttpRequest();

    let f = document.getElementById("addNewGalery");
    let fData = new FormData(f);

    fData.append("name", f.elements["name"].value);

    xhttp.onload = function () {
        getAllGaleries();
    }

    xhttp.open("POST", "../includes/functions/galeries/registerNewGalery.php");
    xhttp.send(fData);
}

/**
 * Modifie une galerie.
 * @param {int} id
 */
function modifyThisGalery(id) {
    const xhttp = new XMLHttpRequest();

    let f = document.getElementById("updateGalery" + id);
    let fData = new FormData(f);

    fData.append("name", f.elements["name"].value);

    let tags = f.elements["tags[]"];
    for (let i = 0, len = tags.length; i < len; i++) {
        if (tags[i].checked) {
            fData.append("tags[]", tags[i].value);
        }
    }

    xhttp.onload = function () {
        getAllGaleries();
        openGalerySettings(id);
    }

    xhttp.open("POST", "../includes/functions/galeries/modifyThisGalery.php?galery=" + id);
    xhttp.send(fData);
}

/**
 * Supprime de la base de donnée la galerie et actualise le tableau.
 * @param {int} id de la galery
 */
function unregisterThisGalery(id) {
    if (window.confirm("Do you really want to unregister this galery? ")) {
        const xhttp = new XMLHttpRequest();

        xhttp.onload = function () {
            getAllGaleries();
        }

        xhttp.open("GET", "../includes/functions/galeries/unregisterThisGalery.php?galery=" + id);
        xhttp.send();
    }
}

/*===============================================================================================*\

	Généralités

\*===============================================================================================*/

/**
 * Affiche ou cache un élément en fonction de son état.
 * @param {int} id de l'objet.
 */
function toggleVisibility(id) {
    let s = document.getElementById(id);

    if (s.style.display === "block") {
        s.style.display = "none";
    } else {
        s.style.display = "block";
    }
}

/**
 * Ouvre une modal.
 * @param {string} id de la modal à ouvrir.
 */
function openModal(id) {
    let $modal = document.getElementById(id);
    $modal.classList.add("opened");
}

/**
 * Ferme une modal.
 * @param {string} id de la modal à fermer.
 */
function closeModal(id) {
    let $modal = document.getElementById(id);
    $modal.classList.remove("opened");
}

/**
 * Analyse les cliques pour fermer une modal quand l'utilisateur clique sur le côté.
 * @param {event} event de clique.
 */
window.onclick = function (event) {
    // Fermer une modal.
    if (event.target.classList.contains("modal")) {
        event.target.classList.remove("opened");
    }

    // Fermer un diaporama.
    if (event.target.classList.contains("slide")) {
        event.target.parentElement.classList.remove("opened");
    }
}