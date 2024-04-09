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
					document.location.href = "#"+tab[tab.length-1].parentNode.id;

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
	let reciver = document.querySelector('input[name="reciver"]:checked').value;

	setInterval(timer,1000);

	function timer(){
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && xhttp.responseText!='') {
				var pere = document.getElementById("msgContener");

				var e = document.createElement("span");
				e.innerHTML = xhttp.responseText;
				
				pere.appendChild(e);

				let tab = document.getElementsByClassName("msg");
				document.location.href = "#"+tab[tab.length-1].parentNode.id;
				document.getElementById("msgToSend").focus();
			}
		}
		var file = "php/msgInstantane.php";
		xhttp.open("POST", file, true);
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

		let tab = document.getElementsByClassName("msg");
		let post = "reciver="+reciver+"&last="+tab[tab.length-1].parentNode.id;
		if(target >= 1){
			post = post+"&target="+target;
		}
		xhttp.send(post);
	}
}

function loadChat(target){
	let reciver = document.querySelector('input[name="reciver"]:checked').value;

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("modifierHide").innerHTML = xhttp.responseText;
			entree(target);
			instantane(target);
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

function block(target){
	let reciver = document.querySelector('input[name="reciver"]:checked').value;

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById(reciver).remove();
			document.getElementById("_"+reciver).remove();
			document.getElementsByClassName("radioCache")[0].checked = 1;
			loadChat(target);
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

function reportAccount(target){
	reciver = document.getElementById("Reciver").innerHTML;

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
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