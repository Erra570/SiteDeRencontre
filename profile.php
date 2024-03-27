<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exeption $e){
	die('Erreur : '.$e->getMessage());
}

//if(isset($_SESSION['password']) AND isset($_SESSION['user'])){
if(isset($_GET['password']) AND isset($_GET['user'])){
	$user = htmlspecialchars($_GET['user']);
	$password = htmlspecialchars($_GET['password']);
	$User_tab = $bdd->prepare('SELECT IdAccount, Pseudo, Password, ProfilePictureFile FROM Account WHERE Pseudo=:user AND Password=:password');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	if($User=$User_tab->fetch()){ ?>
		<!DOCTYPE html>
		<html>
			<head>
				<?php include('head.html');?>
				<link rel="stylesheet" type="text/css" href="css/profile.css" media="all" />
			</head>
			<body>
				<div class="centreur">
					<div id="profilePres">
						<div>
							<div id="profileTop">
								<img id="profilePicture" src="img/<?php echo $User['IdAccount'].'/'.$User['ProfilePictureFile'];?>">
							</div>
							<div id="profileBottom">
							</div>
						</div>
					</div>
					<div class="right" id="pictureContener">
						<?php 
							$Picture_tab = $bdd->query('SELECT ImgFile FROM Image WHERE IdAccount='.$User['IdAccount']);
							if($Picture=$Picture_tab->fetch()){
								do{
									echo '<img src="img/'.$User['IdAccount'].'/'.$Picture["ImgFile"].'">';
								}while($Picture=$Picture_tab->fetch());
							}
							else{
								echo '<div id="nopicture"></div>';
							}
						?>
					</div>
					<div class="right" id="modifierHide">
						<h2>Informations :</h2>
						<label for="pseudo">Pseudo : </label><br>
						<label for="name">Nom :</label><br>
						<label for="firstname">Prenom :</label><br>
						<div>
							<h3>Adresse</h3>
							<label for="password">Pays : </label><br>
							<label for="password">Ville : </label><br>
							<label for="password">Rue : </label><br>
							<label for="password">Numero : </label><br>
						</div>
						<div>
							<h3>Descriptif</h3>
							<label for="password">Sexe : </label><br>
							<label for="password">Date de naissance : </label><br>
							<label for="password">Espece : </label><br>
							<label for="password">Jauge humanitée : </label><br>
							<label for="password">Taille : </label><br>
							<label for="password">Poids : </label><br>
							<label for="password">Couleur des yeux : </label><br>
						</div>
						Changer le mot de passe
						<form method="post" action="new_password.php">
							<label for="password">Mot de passe :</label><br>
							<input type="password" name="password" id="password" maxlength="255" minlength="6"/><br>
							<label for="password">Nouveau mot de passe :</label><br>
							<input type="password" name="password" id="password" maxlength="255" minlength="6"/><br>
							<label for="password_confirm">Confirmation du mot de passe :</label><br>
							<input type="password" name="password_confirm" id="password_confirm" maxlength="255" minlength="6"/><br>
							<input type="submit" name="Ajouter" value="Changer">
						</form>
					</div>
				</div>
			</body>
		</html>
	<?php }
	else{header('Location: /');}
}
else{header('Location: /');}?>
