function entree(target) {
	document.getElementById("msgToSend").onkeydown = function(e){
		if(e.which == 13){
			target = document.getElementById("Reciver").innerHTML;

			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4) {
					/*let text = xhttp.responseText.split("&");

					var pere = document.getElementById("pictureContener");

					var e = document.createElement("div");
					e.id = "img"+text[0];
					e.className = "pictureContener";

					var ip = document.createElement("img");
					ip.src = "img/poubelle_noire.png";
					ip.className = "poubelle";
					ip.setAttribute("onclick", "rmPicture("+text[0]+","+target+")");
					e.appendChild(ip);

					var i = document.createElement("img");
					i.src = "img/"+text[1];
					e.appendChild(i);

					pere.insertBefore(e,pere.lastChild.previousSibling);
					showHide('addPictureContener');*/
					console.log("thumbs");
				}
			}
			var file = "newMsg.php";
			xhttp.open("POST", file, true);
			
			const formData = new FormData()

			if(target >= 1){
				formData.append('target', target);
			}
			formData.append('reciver', reciver);

			xhttp.send(formData);
		}
	}
}