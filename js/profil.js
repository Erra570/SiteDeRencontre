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

function getProfilPicture(){
     document.getElementById("profilPicture").click();
}

function showHide(id){
	if(document.getElementById(id).style.display == "none" || document.getElementById(id).style.display==''){
		document.getElementById(id).style.display = "flex";
	}
	else{
		document.getElementById(id).style.display = "none";
	}
}

function hideShow(id){
	if(document.getElementById(id).style.display == "none"){
		document.getElementById(id).style.display = "flex";
	}
	else{
		document.getElementById(id).style.display = "none";
	}
}

function newPicture(){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			var pere = document.getElementById("pictureContener");

			var e = document.createElement("div");
			e.className = "pictureContener";

			var ip = document.createElement("img");
			ip.src = "img/poubelle_noire.png";
			ip.className = "poubelle";
			e.appendChild(ip);

			var i = document.createElement("img");
			i.src = "img/"+xhttp.responseText;
			e.appendChild(i);

			pere.insertBefore(e,pere.lastChild.previousSibling);
			showHide('addPictureContener');
		}
	}
	var file = "newPicture.php?user=Legolas64&password=leff";
	xhttp.open("POST", file, true);

	/*recupere le fichier de l'image et l'envoie*/
	const files = document.querySelector('[name=picture]').files
	const formData = new FormData()
	formData.append('picture', files[0])

	xhttp.send(formData);
}

function rmPicture(nb){
	var n = parseInt(nb);

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("img"+n).style.display = "none";
		}
	}
	var file = "rmPicture.php?user=Legolas64&password=leff";
	xhttp.open("POST", file, true);
	/*ligne necessaire pour faire une requete post*/
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send("idimg="+n);
}

function newProfilPicture(){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("imgProfilPicture").src = "img/"+xhttp.responseText;
			showHide('modifyProfilPictureContener');
			document.getElementById("rmButton").style.display = "flex";
		}
	}
	var file = "newProfilPicture.php?user=Legolas64&password=leff";
	xhttp.open("POST", file, true);

	/*recupere le fichier de l'image et l'envoie*/
	const files = document.querySelector('[name=profilPicture]').files
	const formData = new FormData()
	formData.append('profilPicture', files[0])

	xhttp.send(formData);
}

function rmProfilPicture(){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("imgProfilPicture").src = "img/"+xhttp.responseText;
			showHide('modifyProfilPictureContener');
			document.getElementById("rmButton").style.display = "none";
		}
	}
	var file = "rmProfilPicture.php?user=Legolas64&password=leff";
	xhttp.open("GET", file, true);

	xhttp.send();
}