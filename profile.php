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
				<?php include("bandeau.php"); ?>
				<div class="centreur">
					<div id="profilePres">
						<div>
							<div class="centreHorizontalement" id="profileTop" onclick="showHide('modifyProfilePictureContener')">
								<svg class="plus plusProfile" viewBox="0 0 100 100">
									<path class="line top" d="m 10 50 l 80 0" />
									<path class="line bottom" d="m 50 10 l 0 80 " />
								</svg>
								<img id="profilePicture" src="img/<?php echo $User['IdAccount'].'/'.$User['ProfilePictureFile'];?>">
							</div>
							<div id="modifyProfilePictureContener" class="formCenter">
								<div id="formPicture">
									<h3>
										<?php if($User['ProfilePictureFile'] == 'ProfileDefaultPicture.png'){
											echo "Ajouter une photo de profile";
										}
										else{
											echo "Modifier la photo de profile";
										}?>	
									</h3>
									<div class="button" onclick="getProfilePicture()">
										<div>Importer une photo</div>
										<input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
										<input type="file" name="profilePicture" id="profilePicture" accept="image/*">
									</div>
									<?php if($User['ProfilePictureFile'] != 'ProfileDefaultPicture.png'){
										echo '<div class="button"><div>Supprimer</div></div>';
									}?>	
									<div class="button lastButton" onclick="showHide('modifyProfilePictureContener')">
										<div>Annuler</div>
									</div>
								</div>
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
									echo '<div class="pictureContener">
											<img class="poubelle" src="img/poubelle_noire.png">
											<img src="img/'.$User['IdAccount'].'/'.$Picture["ImgFile"].'">
										</div>';
								}while($Picture=$Picture_tab->fetch());
							}
						?>
						<div id="nopicture" class="pictureContener" onclick="showHide('addPictureContener')">
							<svg class="plus" viewBox="0 0 100 100">
								<path class="line top" d="m 10 50 l 80 0" />
								<path class="line bottom" d="m 50 10 l 0 80 " />
							</svg>
						</div>
						<div id="addPictureContener" class="formCenter">
							<div id="formPicture">
								<h3>Ajouter une photo dans la galerie</h3>
								<div class="button" onclick="getPicture()">
									<div>Importer une photo</div>
									<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
									<input type="file" name="picture" id="picture" value="Importer une photo" accept="image/*">
								</div>
								<div class="button lastButton" onclick="showHide('addPictureContener')">
									<div>Annuler</div>
								</div>
							</div>
						</div>
					</div>
					<div class="right" id="modifierHide">
						<h2>Informations :</h2>
						<div class="blocDInfos">
							<label for="pseudo">Pseudo : </label>
							<input type="text" name="pseudo" id="pseudo" value="<?php echo $User['Pseudo'] ?>" required><br>
							<label for="name">Nom :</label>
							<input type="text" name="name" id="name" value="<?php echo $User['Name'] ?>" required><br>
							<label for="firstname">Prenom :</label>
							<input type="text" name="firstname" id="firstname" value="<?php echo $User['FirstName'] ?>" required><br>
						</div>
						<div>
							<div class="h3">
								<h3>Adresse</h3><div class="traitSeparation"></div>
							</div>
							<div class="blocDInfos">
								<label for="country">Pays : </label>
								<input type="text" name="country" id="country" value="<?php echo $User['Country'] ?>" required><br>
								<label for="city">Ville : </label>
								<input type="text" name="city" id="city" value="<?php echo $User['City'] ?>" required><br>
								<label for="street">Rue : </label>
								<input type="text" name="street" id="street" value="<?php echo $User['Street'] ?>"><br>
								<label for="adressNumber">Numero : </label>
								<input type="number" name="adressNumber" id="adressNumber" value="<?php echo $User['AdressNumber'] ?>"><br>
							</div>
						</div>
						<div>
							<div class="h3">
								<h3>Descriptif</h3><div class="traitSeparation"></div>
							</div>
							<div class="blocDInfos">
								<label for="sexe">Sexe : </label>
								<input type="text" name="sexe" id="sexe" value="<?php echo $User['Sexe'] ?>"><br>
								<label for="dateOfBirth">Date de naissance : </label>
								<input type="date" name="dateOfBirth" id="dateOfBirth" value="<?php echo $User['DateOfBirth'] ?>"><br>
								<label for="species">Espece : </label>
								<input type="text" name="species" id="species" value="<?php echo $User['Species'] ?>"><br>
								<label for="humanoidGauge">Jauge humanitée : </label>
								<input type="range" name="humanoidGauge" id="humanoidGauge" min="0" max="10" value="<?php echo $User['HumanoidGauge'] ?>"><br>
								<label for="size">Taille : </label>
								<input type="number" name="size" id="size" min="0" value="<?php echo $User['Size'] ?>"><br>
								<label for="weight">Poids : </label>
								<input type="number" name="weight" id="weight" min="0" value="<?php echo $User['Weight'] ?>"><br>
								<label for="eyeColor">Couleur des yeux : </label>
								<input type="text" name="eyeColor" id="eyeColor" value="<?php echo $User['EyeColor'] ?>"><br>
							</div>
						</div>
						<div>
							<div class="h3">
								<h3>Changer le mot de passe</h3><div class="traitSeparation"></div>
							</div>
							<form method="post" action="new_password.php">
								<label for="password">Mot de passe :</label><br>
								<input type="password" name="password" id="password" maxlength="255" minlength="6"/><br>
								<label for="newPassword">Nouveau mot de passe :</label><br>
								<input type="password" name="newPassword" id="newPassword" maxlength="255" minlength="6"/><br>
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
