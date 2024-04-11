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
		if(e.which == 13 && document.getElementById("msgToSend").value!=''){
			reciver = document.getElementById("Reciver").innerHTML;
			let content = document.getElementById("msgToSend").value;

			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4) {
					var pere = document.getElementById("msgContener");

					var e = document.createElement("span");
					e.innerHTML = xhttp.responseText;
					
					pere.appendChild(e);

					let tab = document.getElementsByClassName("msg");
					if(tab.length != 0){
						document.location.href = "#"+tab[tab.length-1].parentNode.id;
					}

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


function instantane(target){
	console.log("instantane");
	setInterval(timer,1000);

	function timer(){
		let reciver = document.querySelector('input[name="reciver"]:checked').value;
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && xhttp.responseText!='') {
				var pere = document.getElementById("msgContener");

				var e = document.createElement("span");
				e.innerHTML = xhttp.responseText;
				
				pere.appendChild(e);

				let tab = document.getElementsByClassName("msg");
				if(tab.length != 0){
					document.location.href = "#"+tab[tab.length-1].parentNode.id;
				}
				document.getElementById("msgToSend").focus();
			}
		}
		var file = "php/msgInstantane.php";
		xhttp.open("POST", file, true);
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

		let tab = document.getElementsByClassName("msg");
		let post = "reciver="+reciver+"&last=";
		if(tab.length == 0){
			post = post + 0;
		}else{
			post = post +tab[tab.length-1].parentNode.id;
		}
		if(target >= 1){
			post = post+"&target="+target;
		}
		xhttp.send(post);
	}
}

function loadChat(target, idMsg){
	let reciver = document.querySelector('input[name="reciver"]:checked').value;

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("right").innerHTML = xhttp.responseText;
			entree(target);
			let tab = document.getElementsByClassName("msg");
			if(tab.length != 0 && !(target >= 1)){
				document.location.href = "#hour"+tab[tab.length-1].parentNode.id;
			}
			if(target >= 1){
				if(idMsg){
					document.location.href = "#hour"+idMsg;
					document.getElementById(idMsg).style = "filter: drop-shadow(0 0 0.1rem #602320);";
				}
				document.getElementById("msgWriter").style.width = '64vw';
				document.getElementById("spanTroisPoint").style.top = 'calc(7vh + 12px)';
			}
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

function block(target){
	let reciver = document.querySelector('input[name="reciver"]:checked').value;

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById(reciver).remove();
			document.getElementById("_"+reciver).remove();
			let tab = document.getElementsByClassName("radioCache");
			if(tab.length != 0){
				tab[0].checked = 1;
				loadChat(target);
			}
			else{
				document.getElementById("modifierHide").innerHTML = "Il n'y a personne ici";
			}
		}
	}
	var file = "php/block.php";
	xhttp.open("POST", file, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let post = "reciver="+reciver;
	if(target >= 1){
		post = post+"&target="+target;
	}
	xhttp.send(post);
}

//afficher le message
function reportAccount(target){
	reciver = document.getElementById("Reciver").innerHTML;

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			if(!!document.getElementById("signalement")){
				document.getElementById("signalement").innerHTML = "Cet utilisateur a déjà été signalé"
			}
			else{
				var pere = document.getElementById("msgTopLeft");

				var elt = document.createElement("div");
				elt.id = "signalement";
				elt.innerHTML = "Cet utilisateur a été signalé";

				pere.appendChild(elt);
			}
		}
	}
	var file = "php/reportAccount.php";
	xhttp.open("POST", file, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let post = "reciver="+reciver;
	if(target >= 1){
		post = post+"&target="+target;
	}
	xhttp.send(post);
}

function accept(reciver, target){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			var pere = document.getElementById("discussionOuverte");

			var input = document.createElement("input");
			input.type = "radio";
			input.className = "radioCache";
			input.value = reciver;
			input.id = reciver;
			input.name = "reciver";
			if(target >= 1){
				input.setAttribute("onclick", "loadChat('"+target+"')");
			}
			else{
				input.setAttribute("onclick", "loadChat()");
			}

			var label = document.createElement("label");
			label.className = "profil";
			label.htmlFor = reciver;
			label.id = "_"+reciver;

			var img = document.createElement("img");
			img.src = "img/"+xhttp.responseText;
			img.className = "profilPicture";

			var div = document.createElement("div");
			div.innerHTML = reciver;

			label.appendChild(img);
			label.appendChild(div);
			pere.appendChild(input);
			pere.appendChild(label);

			document.getElementById(reciver).remove();
		}
	}
	var file = "php/accept.php";
	xhttp.open("POST", file, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let post = "reciver="+reciver;
	if(target >= 1){
		post = post+"&target="+target;
	}
	xhttp.send(post);
}

function reject(reciver, target){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById(reciver).remove();
		}
	}
	var file = "php/reject.php";
	xhttp.open("POST", file, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let post = "reciver="+reciver;
	if(target >= 1){
		post = post+"&target="+target;
	}
	xhttp.send(post);
}

function rmMsg(idmsg, target){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById(idmsg).remove();
		}
	}
	var file = "php/rmMsg.php";
	xhttp.open("POST", file, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let post = "idmsg="+idmsg;
	if(target >= 1){
		post = post+"&target="+target;
	}
	xhttp.send(post);
}

function reportMsg(idmsg, target){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
		}
	}
	var file = "php/reportMsg.php";
	xhttp.open("POST", file, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let post = "idmsg="+idmsg;
	if(target >= 1){
		post = post+"&target="+target;
	}
	xhttp.send(post);
}