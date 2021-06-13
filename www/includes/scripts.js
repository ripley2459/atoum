/****************************

	MODAL

****************************/

function openModal($modal_id){
	var $modal = document.getElementById($modal_id);
	$modal.classList.add("opened");
}

function closeModal($modal_id){
	var $modal = document.getElementById($modal_id);
	$modal.classList.remove("opened");
}

window.onclick = function(event) {
	if(event.target.classList.contains("modal")){
		event.target.classList.remove("opened");
	}
}

/****************************

	ACCORDIONS

*****************************/

var acc = document.getElementsByClassName("accordion_trigger");
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

function toggleVisibility($folder, $button){
	var $targetFolder = $folder;
	var $targetButton = $button;
	document.getElementById($targetFolder).classList.toggle("opened");
	document.getElementById($targetButton).classList.toggle("opened");
}

/****************************

	SEARCH FOR TAG

*****************************/

function searchForTag() {
	var input, filter, table, tr, td, i, txtValue;

	input = document.getElementById("tags_search");
	filter = input.value.toUpperCase();

	table = document.getElementById("tags_list");
	tr = table.getElementsByTagName("tr");

	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0];

		if (td) {
			txtValue = td.textContent || td.innerText;

			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			}
			else {
				tr[i].style.display = "none";
			}
		}       
	}
}