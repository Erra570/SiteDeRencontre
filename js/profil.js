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

function newPicture(target){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			let text = xhttp.responseText.split("&");

			var pere = document.getElementById("pictureContener");

			var e = document.createElement("div");
			e.id = "img"+text[0];
			e.className = "pictureContener";

			var ip = document.createElement("img");
			ip.src = "img/annuler2.png";
			ip.className = "poubelle";
			ip.setAttribute("onclick", "rmPicture("+text[0]+","+target+")");
			ip.setAttribute("onmouseover", "this.src='img/annuler.png'");
			ip.setAttribute("onmouseout", "this.src='img/annuler2.png'");
			e.appendChild(ip);

			var i = document.createElement("img");
			i.src = "img/"+text[1];
			e.appendChild(i);

			pere.insertBefore(e,pere.lastChild.previousSibling);
			showHide('addPictureContener');
		}
	}
	var file = "php/newPicture.php";
	xhttp.open("POST", file, true);

	/*recupere le fichier de l'image et l'envoie*/
	const files = document.querySelector('[name=picture]').files
	const formData = new FormData()
	formData.append('picture', files[0])

	if(target >= 1){
		formData.append('target', target);
	}
	xhttp.send(formData);
}

function rmPicture(nb, target){
	var n = parseInt(nb);

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("img"+n).remove();
		}
	}
	var file = "php/rmPicture.php";
	xhttp.open("POST", file, true);
	/*ligne necessaire pour faire une requete post*/
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	if(target >= 1){
		xhttp.send("idimg="+n+"&target="+target);
	}
	else{
		xhttp.send("idimg="+n);
	}
}

function newProfilPicture(target){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("imgProfilPicture").src = "img/"+xhttp.responseText;
			showHide('modifyProfilPictureContener');
			document.getElementById("rmButton").style.display = "flex";
		}
	}
	var file = "php/newProfilPicture.php";
	xhttp.open("POST", file, true);

	/*recupere le fichier de l'image et l'envoie*/
	const files = document.querySelector('[name=profilPicture]').files;
	const formData = new FormData();
	formData.append('profilPicture', files[0]);

	if(target >= 1){
		formData.append('target', target);
	}
	xhttp.send(formData);

}

function rmProfilPicture(target){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("imgProfilPicture").src = "img/"+xhttp.responseText;
			showHide('modifyProfilPictureContener');
			document.getElementById("rmButton").style.display = "none";
		}
	}
	var file = "php/rmProfilPicture.php";
	xhttp.open("POST", file, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	if(target >= 1){
		xhttp.send("target="+target);
	}
	else{
		xhttp.send();
	}
}

function modifyProfil(target){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("result").innerHTML = xhttp.responseText;
		}
	}
	var file = "php/modifyProfil.php";
	xhttp.open("POST", file, true);
	var formData = new FormData(document.getElementById("profil"));
	xhttp.send(formData);
}