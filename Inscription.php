
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="js/inscription.js"></script>
		<?php include('php/head.html');?>
	</head>
	<body>
		<form method="post" action="">
			<label for="user">Pseudo :</label><br>
			<input type="text" name="user" id="user" maxlength="255"/><br>
			<label for="prenom">Prénom : </label><br>
			<input type="text" name="prenom" id="prenom" maxlength="127"/><br>
			<label for="nom">Nom : </label><br>
			<input type="text" name="nom" id="nom" maxlength="127"/><br>
			<label for="mail">Mail :</label><br>
			<input type="email" name="mail" id="mail" maxlength="255"/><br>
			<label for="password">Mot de passe :</label><br>
			<input type="password" name="password" id="password" maxlength="255" minlength="6"/><br>
			<label for="password_confirm">Confirmation du mot de passe :</label><br>
			<input type="password" name="password_confirm" id="password_confirm" maxlength="255" minlength="6"/><br>
			<label for="date_de_naissance">Date de naissance : </label><br>
			<input type="date" name="date_de_naissance" id="date_de_naissance" maxlength="32"/><br>
			<label for="humanoid_gauge">pourcentage de resemblance a un humain : </label><br>
			<input type="range" name="humanoid_gauge" id="humanoid_gauge" min="0" max="10"/><div>humain</div><br>
			<label for="Species">Espece : </label><br>
			<input type="text" name="Species" id="Species" maxlength="127" value="France"/><br>
			<label for="Sexe">Sexe : </label><br>
			<input type="text" name="Sexe" id="Sexe"/><br>
			<label for="contry">Pays : </label><br>
			<input type="text" name="contry" id="contry" maxlength="127" value="France"/><br>
			<label for="city">Ville : </label><br>
			<input type="text" name="city" id="city" maxlength="127"/><br>
			<label for="street">Rue : </label><br>
			<input type="text" name="street" id="street" maxlength="127"/><br>
			<input type="submit" name="Inscription" value="s'inscrire"/>
		</form>
	</body>
</html>