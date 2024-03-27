var efface = null;

function messageriecheck(){
	let tmp = "_"+document.getElementById("user").value;
	document.getElementById(tmp).style.display = "none";
	if(!isnull(efface)){
		document.getElementById(efface).style="";
	}
	efface = tmp;
}