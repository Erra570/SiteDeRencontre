function showHide(id){
	if(document.getElementById(id).style.display == "none" || document.getElementById(id).style.display==''){
		document.getElementById(id).style.display = "flex";
	}
	else{
		document.getElementById(id).style.display = "none";
	}
}

function entree(target) {
	document.getElementById("msgToSend").onkeydown = function(e){
		if(e.which == 13){
			reciver = document.getElementById("Reciver").innerHTML;
			let content = document.getElementById("msgToSend").value;

			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4) {
					let tab = document.getElementsByClassName("msg");

					var pere = document.getElementById("msgContener");

					var e = document.createElement("div");
					e.className = "sender";
					e.id = parseInt(tab[tab.length-1].parentNode.id)+1;

					var msg = document.createElement("div");
					msg.className = "msg";

					var content = document.createElement("div");
					content.innerHTML = document.getElementById("msgToSend").value;
					content.className = "content";

					var hour = document.createElement("div");
					hour.innerHTML = "0 min";
					hour.className = "hour";

					msg.appendChild(content);
					msg.appendChild(hour);
					e.appendChild(msg);
					pere.appendChild(e);
					/*ip.src = "img/poubelle_noire.png";
					ip.className = "poubelle";
					ip.setAttribute("onclick", "rmPicture("+text[0]+","+target+")");
					e.appendChild(ip);

					var i = document.createElement("img");
					i.src = "img/"+text[1];
					e.appendChild(i);

					pere.insertBefore(e,pere.lastChild.previousSibling);
					showHide('addPictureContener');*/
					console.log(xhttp.responseText);
					document.location.href = "#"+e.id;

					document.getElementById("msgToSend").value = "";
				}
			}
			var file = "php/newMsg.php";
			xhttp.open("POST", file, true);
			
			const formData = new FormData()

			if(target >= 1){
				formData.append('target', target);
			}
			formData.append('reciver', reciver);
			formData.append('content', content);

			xhttp.send(formData);
		}
	}
}

function loadChat(target){
	let reciver = document.querySelector('input[name="reciver"]:checked').value;

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("modifierHide").innerHTML = xhttp.responseText;
			entree(target);
			let tab = document.getElementsByClassName("msg");
			document.location.href = "#"+tab[tab.length-1].parentNode.id;
		}
	}
	var file = "php/chat.php";
	xhttp.open("POST", file, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let post = "reciver="+reciver;
	if(target >= 1){
		post = post+"&target="+target;
	}
	xhttp.send(post);
}