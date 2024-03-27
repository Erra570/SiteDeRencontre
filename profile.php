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
	$User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	if($User=$User_tab->fetch()){ ?>
		<!DOCTYPE html>
		<html>
			<head>
				<?php include('head.html');?>
				<link rel="stylesheet" type="text/css" href="css/profile.css" media="all" />
				<script type="text/javascript" src="js/profile.js"></script>
			</head>
			<body>
				<div class="centreur">
					<div id="profilePres">
						<div>
							<div class="centreHorizontalement" id="profileTop">
								<img id="profilePicture" src="img/<?php echo $User['IdAccount'].'/'.$User['ProfilePictureFile'];?>">
							</div>
							<div class="centreHorizontalement" id="profileBottom">
								<div id="contenerBas">
									<div>
										<p><?php echo $User['Pseudo'];?></p>
									</div>
									<div>
										<p><?php if(isset($User['Species'])){echo $User['Species'];}?></p>
										<p><?php if(isset($User['LoveSituation'])){echo $User['LoveSituation'];}?></p>
									</div>
									<div>
										<p>Description :</p>
									</div>
									<div>
										<p id="description"><?php if(isset($User['WelcomeMessage'])){echo $User['WelcomeMessage'];}?></p>
									</div>
									<div>
										<input type="button" name="modifierProfile" id="modifierProfile" onclick="modifierApparition()" value="modifier profile">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="right" id="pictureContener">
						<?php 
							$Picture_tab = $bdd->query('SELECT ImgFile FROM Image WHERE IdAccount='.$User['IdAccount']);
							if($Picture=$Picture_tab->fetch()){
								do{
									echo '<div class="pictureContener"><img src="img/'.$User['IdAccount'].'/'.$Picture["ImgFile"].'"></div>';
								}while($Picture=$Picture_tab->fetch());
							}
						?>
						<div id="nopicture" class="pictureContener">
							<svg id="croix" viewBox="0 0 100 100">
								<path class="line top" d="m 10 50 l 80 0" />
								<path class="line bottom" d="m 50 10 l 0 80 " />
							</svg>
						</div>
					</div>
					<div class="right" id="modifierHide">
						<h2>Informations :</h2>
						<div class="blocDInfos">
							<label for="pseudo">Pseudo : </label><br>
							<label for="name">Nom :</label><br>
							<label for="firstname">Prenom :</label><br>
						</div>
						<div>
							<div class="h3">
								<h3>Adresse</h3><div class="traitSeparation"></div>
							</div>
							<div class="blocDInfos">
								<label for="country">Pays : </label><br>
								<label for="city">Ville : </label><br>
								<label for="street">Rue : </label><br>
								<label for="adressNumber">Numero : </label><br>
							</div>
						</div>
						<div>
							<div class="h3">
								<h3>Descriptif</h3><div class="traitSeparation"></div>
							</div>
							<div class="blocDInfos">
								<label for="sexe">Sexe : </label><br>
								<label for="dateOfBirth">Date de naissance : </label><br>
								<label for="species">Espece : </label><br>
								<label for="humanoidGauge">Jauge humanitée : </label><br>
								<label for="size">Taille : </label><br>
								<label for="weight">Poids : </label><br>
								<label for="eyeColor">Couleur des yeux : </label>
								<input type="color" name="eyeColor" id="eyeColor"><br>
							</div>
						</div>
						<div>
							<div class="h3">
								<h3>Changer le mot de passe</h3><div class="traitSeparation"></div>
							</div>
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
				</div>
			</body>
		</html>
	<?php }
	else{header('Location: /');}
}
else{header('Location: /');}?>
