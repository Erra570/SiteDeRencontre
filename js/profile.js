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