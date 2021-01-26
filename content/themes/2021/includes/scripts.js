/****************************

	ACCORDIONS

*****************************/

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++){
	acc[i].addEventListener("click", function(){
		this.classList.toggle("active");
		var panel = this.nextElementSibling;
		if(panel.style.display === "block"){
			panel.style.display = "none";
		}
		else{
			panel.style.display = "block";
		}
	});
}

/****************************

	VISIBILITY

*****************************/

function toggleVisibility(folder, button){
	var targetFolder = folder;
	var targetButton = button;
	document.getElementById(targetFolder).classList.toggle("opened");
	document.getElementById(targetButton).classList.toggle("opened");
}

/****************************

	DRAG N DROP

*****************************/

function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");
  ev.target.appendChild(document.getElementById(data));
}