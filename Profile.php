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
				<div id="profilePres">
					<div id="profileLeft">
						<img id="profilePicture" src="img/<?php echo $User['IdAccount'].'/'.$User['ProfilePictureFile'];?>">
					</div>
					<div id="profileRight">
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
				</div>
				<div>
					<h2>Informations :</h2>
					Pseudo : 
					Nom :
					Prenom :
					<div>
						<h3>Adresse</h3>
						Pays : 
						Ville : 
						Rue : 
						Numero : 
					</div>
					<div>
						<h3>Descriptif</h3>
						Sexe : 
						Date de naissance : 
						Espece : 
						Jauge humanitée : 
						Taille : 
						Poids : 
						Couleur des yeux : 
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
			</body>
		</html>
	<?php }
	else{header('Location: /');}
}
else{header('Location: /');}?>
