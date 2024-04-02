var efface = null;

/*fait en sorte que l'on ne puisse pas verifier le message de un utilisateur vers lui meme*/
function messageriecheck(){
	let tmp = document.getElementById("user").value;
	document.getElementById("_"+tmp).style.display = "none";
	if(efface != null){
		document.getElementById(efface).style="";
	}
	if(document.getElementById("_user").value == tmp){
		let tab = document.getElementById("_user").options;
		if(tmp < tab.length && tab[tmp].value != tmp){
			document.getElementById("_user").value = tab[tmp].value;
		}
		else{
			let i = 0;
			while(i<tab.length && tab[i].value == tmp){
				i++
			}
			if(i==tab.length){
				document.getElementById("_user").value = "";
			}
			else{
				document.getElementById("_user").value = tab[i].value
			}
		}
	}
	efface = "_"+tmp;
}

function loadProfil(){

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("profil").innerHTML = xhttp.responseText;
		}
	}
	var file = "php/profilSansBandeau.php";
	xhttp.open("POST", file, true);
	/*ligne necessaire pour faire une requete post*/
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send("target="+document.getElementById("user").value);
}