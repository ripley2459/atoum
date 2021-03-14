function addTest(str)
{
	var xhttp;																					//xhttp objet
	if(str == "")																				//Vérifie si contient des données
	{
		document.getElementById("txtHint").innerHTML = "";										//Si oui, renvoiyer rien
		return;
	}

	xhttp = new XMLHttpRequest();																//instance de classe XMLHttpRequest
	xhttp.onreadystatechange = function()														//
	{
		if(this.readyState == 4 && this.status == 200)
		{
			document.getElementById("txtHint").innerHTML = this.responseText;					//
		}
	};

	xhttp.open("POST", "relations.php?q="+str, true);											//réccupère les donnéees sélectionnées
	xhttp.send();																				//envoie les données sélectionnées
}