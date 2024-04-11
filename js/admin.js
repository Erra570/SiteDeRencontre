function loadProfil(){

	let type = document.querySelector('input[name="type"]:checked').value;
	let target = document.getElementById("user").value;

	loadknownProfil(target, type);
}

function loadknownProfil(target, type, idMsg){
	document.getElementById("user").value = target;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("emulateur").innerHTML = xhttp.responseText;

			document.getElementById("centreur").style.margin = '0px';

			if(type=="Messagerie"){
				loadChat(document.getElementById("user").value);
				document.location.href = "#hour"+idMsg;
				document.getElementById(idMsg).style = "filter: drop-shadow(0 0 0.1rem #602320);"
			}
		}
	}
	var file = "php/profilSansBandeau.php";
	if(type=="Messagerie"){
		file = "php/messagerieSansBandeau.php";
	}
	xhttp.open("POST", file, true);
	/*ligne necessaire pour faire une requete post*/
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send("target="+target);

}