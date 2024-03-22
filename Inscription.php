
<!DOCTYPE html>
<html>
	<head>
		<?php include('head.html');?>
	</head>
	<body>
		<form method="post" action="">
			<label for="user">Pseudo :</label><br>
			<input type="text" name="user" maxlength="255"/><br>
			<label for="prenom">Prénom : </label><br>
			<input type="text" name="prenom" maxlength="127"/><br>
			<label for="prenom">Nom : </label><br>
			<input type="text" name="prenom" maxlength="127"/><br>
			<label for="mail">Mail :</label><br>
			<input type="email" name="mail" maxlength="255"/><br>
			<label for="password">Mot de passe :</label><br>
			<input type="password" name="password" maxlength="255" minlength="6"/><br>
			<label for="password_confirm">Confirmation du mot de passe :</label><br>
			<input type="password" name="password_confirm" maxlength="255" minlength="6"/><br>
			<label for="date_de_naissance">Date de naissance : </label><br>
			<input type="date" name="date_de_naissance" maxlength="32"/><br>
		</form>
	</body>
</html>