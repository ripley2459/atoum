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

/***************************/