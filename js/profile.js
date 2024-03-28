function modifierApparition(){
	if(document.getElementById("modifierHide").style.display != "block"){
		document.getElementById("modifierHide").style.display = "block";
		document.getElementById("pictureContener").style.display = "none";
	}
	else{
		document.getElementById("modifierHide").style.display = "none";
		document.getElementById("pictureContener").style.display = "flex";
	}
}

function getPicture(){
     document.getElementById("picture").click();
}

function getProfilePicture(){
     document.getElementById("profilePicture").click();
}

function showHide(id){
	if(document.getElementById(id).style.display != "flex"){
		document.getElementById(id).style.display = "flex";
	}
	else{
		document.getElementById(id).style.display = "none";
	}
}