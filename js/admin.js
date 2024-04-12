function loadProfil(){

	let type = document.querySelector('input[name="type"]:checked').value;
	let target = document.getElementById("user").value;

	loadknownProfil(target, type);
}

function loadknownProfil(target, type, sender, idMsg){
	document.getElementById("user").value = target;
	document.getElementById(type).checked = 1;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			if(idMsg){
				let msg = document.getElementById(idMsg);
				let spanmsg = document.getElementById('span'+idMsg);
				if(msg){
					msg.id = '';
					spanmsg.style.display = "none";
					spanmsg.id = '';
				}
			}
			document.getElementById("emulateur").innerHTML = xhttp.responseText;

			document.getElementById("centreur").style.margin = '0px';

			if(type=="Messagerie"){
				if(sender){
					document.getElementById(sender).checked = 1;
				}
				loadChat(document.getElementById("user").value, idMsg);
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


function rmAccount(){
	let target = document.getElementById("user").value;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("option"+target).remove();
			loadProfil();
		}
	}
	var file = "php/rmAccount.php";
	xhttp.open("POST", file, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	post = "target="+target;
	xhttp.send(post);
}