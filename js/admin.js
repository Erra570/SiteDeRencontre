function loadProfil(){

	let type = document.querySelector('input[name="type"]:checked').value;

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("emulateur").innerHTML = xhttp.responseText;

			document.getElementById("centreur").style.margin = '0px';

			if(type=="Messagerie"){
				loadChat(document.getElementById("user").value);
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
	xhttp.send("target="+document.getElementById("user").value);
}