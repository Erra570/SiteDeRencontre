
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="js/inscription.js"></script>
		<?php include('php/head.html');?>
        <link rel="stylesheet" type="text/css" href="css/login.css" media="all" />
	</head>
	<body onload="confirmPassword()">
		<?php include('php/header.php'); ?>
		
		<div id=titreInscription>
			<h1> Créez votre compte </h1><br>
		</div>

		<form id="formInscription" method="post" action="php/validationInscription.php">
			<p> <i style="font-size: 12px;"> Déjà membre ? <a href="login.php"> Connectez-vous ici </i></a>.</p><br>

			<label for="user"> Pseudo :</label>
			<input class="inputText" type="text" name="user" id="user" maxlength="255" required/><br>

			<label for="prenom"> Prénom : </label>
			<input class="inputText" type="text" name="prenom" id="prenom" maxlength="127"/><br>

			<label for="nom"> Nom : </label>
			<input class="inputText" type="text" name="nom" id="nom" maxlength="127"/><br>

			<label for="mail"> Mail :</label>
			<input class="inputText" type="email" name="mail" id="mail" maxlength="255" required/><br>

			<label for="password"> Mot de passe :</label>
			<input class="inputText" type="password" name="password" id="password" maxlength="255" minlength="6" required /> <br>

			<label for="password_confirm"> Confirmation du mot de passe :</label>
			<input class="inputText" type="password" name="password_confirm" id="password_confirm" maxlength="255" minlength="6" required /><br>
			<span id="password_error" style="color: red; display: none;">Les mots de passe ne correspondent pas.</span> <br>

			<label for="date_de_naissance"> Date de naissance : </label>
			<input class="inputText" type="date" name="date_de_naissance" id="date_de_naissance" maxlength="32" required /><br>

			<label for="Species"> Espece : </label>
			<input class="inputText" type="text" name="Species" id="Species" maxlength="127" value=""/><br>

			<label for="Sexe"> Sexe : </label>
			<input type="radio" name="Sexe" id="Sexe"/> masculin
			<input type="radio" name="Sexe" id="Sexe"/> feminin 
			<input type="radio" name="Sexe" id="Sexe"/> autre <br><br><br>

			<label for="contry"> Pays : </label>
			<input class="inputText" type="text" name="contry" id="contry" maxlength="127" value="" required /><br>

			<label for="city"> Ville : </label>
			<input class="inputText" type="text" name="city" id="city" maxlength="127" required /><br>

			<label for="street"> Rue : </label>
			<input class="inputText" type="text" name="street" id="street" maxlength="127"/><br>
			
			<input class="bouton" type="submit" id="submit" name="Inscription" value="s'inscrire"/>
		</form>

		<br>

		<?php include('php/footer.php'); ?>
		
	</body>
</html>