/*===============================================================================================*\

	Généralités

\*===============================================================================================*/

/**
 * Affiche ou cache un élément en fonction de son état.
 * @param {int} id de l'objet.
 */
 function toggleVisibility(id) {
	s = document.getElementById(id);

	if (s.style.display === "block") {
		s.style.display = "none";
	}
	else {
		s.style.display = "block";
	}
}

/*===============================================================================================*\

	Personnes

\*===============================================================================================*/

/**
 * Affiche toutes les personnes enregistrées dans la base de données.
 */
function getAllPersons() {
	const xhttp = new XMLHttpRequest();

	xhttp.onload = function() {
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

	xhttp.onload = function() {
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

	xhttp.onload = function() {
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
		if(tags[i].checked) {
			fData.append("tags[]", tags[i].value);
		}
	}

	xhttp.onload = function() {
		getAllPersons();
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

		xhttp.onload = function() {
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

	xhttp.onload = function() {
		document.getElementById("movies").innerHTML = this.responseText;
	}

	xhttp.open("GET", "../includes/functions/movies/getAllMovies.php");
	xhttp.send();
}

/**
 * Affiche un formulaire pour éditer un film.
 * @param {string} id 
 */
function openMovieSettings(id) {
	const xhttp = new XMLHttpRequest();

	xhttp.onload = function() {
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
		if(tags[i].checked) {
			fData.append("tags[]", tags[i].value);
		}
	}

	xhttp.onload = function() {
		getAllMovies();
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

		xhttp.onload = function() {
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
		if(tags[i].checked) {
			fData.append("tags[]", tags[i].value);
		}
	}

	let persons = f.elements["persons[]"];
	for (let i = 0, len = persons.length; i < len; i++) {
		if(persons[i].checked) {
			fData.append("persons[]", persons[i].value);
		}
	}

	fData.append("preview", f.elements["preview"].value);
	fData.append("movie", f.elements["movie"].value);

	xhttp.onload = function() {
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
		if(tags[i].checked) {
			fData.append("tags[]", tags[i].value);
		}
	}

	let persons = f.elements["persons[]"];
	for (let i = 0, len = persons.length; i < len; i++) {
		if(persons[i].checked) {
			fData.append("persons[]", persons[i].value);
		}
	}

	xhttp.onload = function() {
		getAllMovies();
	}

	xhttp.open("POST", "../includes/functions/movies/bulkUpload.php");
	xhttp.send(fData);
}