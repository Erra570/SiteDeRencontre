<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}


if(isset($_SESSION['password']) AND isset($_SESSION['user'])){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$load = false;
	$target = 0;
	if(isset($_POST['target'])){
		$target = htmlspecialchars($_POST['target']);
		$Admin_tab = $bdd->prepare('SELECT IdAccount,Pseudo,Password FROM Account WHERE Pseudo=:user AND Password=:password AND IdAccount IN (SELECT IdAccount FROM Admin)');
		$Admin_tab->execute(array('user'=>$user, 'password'=>$password));
		$User_tab = $bdd->prepare('SELECT * FROM Account WHERE IdAccount=:idaccount');
		$User_tab->execute(array('idaccount'=>$target));
		$load = $User=$User_tab->fetch() AND $Admin=$Admin_tab->fetch();
	}
	else{
		$User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
		$User_tab->execute(array('user'=>$user, 'password'=>$password));
		$load = $User=$User_tab->fetch();
	}
	if($load){ ?>
		<div id="centreur">
			<div id="profilPres">
				<div>
					<div class="centreHorizontalement" id="profilTop" onclick="showHide('modifyProfilPictureContener')">
						<svg class="plus plusProfil" viewBox="0 0 100 100">
							<path class="linePlus top" d="m 10 50 l 80 0" />
							<path class="linePlus bottom" d="m 50 10 l 0 80 " />
						</svg>
						<img id="imgProfilPicture" src="img/<?php echo $User['IdAccount'].'/'.$User['ProfilPictureFile'];?>">
					</div>
					<div id="modifyProfilPictureContener" class="formCenter">
						<div id="formPicture">
							<h3>
								<?php if($User['ProfilPictureFile'] == 'ProfilDefaultPicture.png'){
									echo "Ajouter une photo de profil";
								}
								else{
									echo "Modifier la photo de profil";
								}?>	
							</h3>
							<div class="button" onclick="getProfilPicture()">
								<div>Importer une photo</div>
								<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
								<input type="file" name="profilPicture" id="profilPicture" value="Importer une photo" accept="image/*" onchange="newProfilPicture(<?php if(isset($_POST['target'])){ echo $target;}?>)">
							</div>
								<div class="button" id="rmButton" onclick="rmProfilPicture(<?php if(isset($_POST['target'])){ echo $target;}?>)" <?php if($User['ProfilPictureFile'] == 'ProfilDefaultPicture.png'){echo 'style="display:none;"';}?>><div>Supprimer</div></div>
							<div class="button lastButton" onclick="showHide('modifyProfilPictureContener')">
								<div>Annuler</div>
							</div>
						</div>
					</div>
					<div class="centreHorizontalement" id="profilBottom">
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
								<input type="button" name="modifierProfil" id="modifierProfil" onclick="modifierApparition(); showHide('sauvgarderChangement'); showHide('annulerChangement'); hideShow('modifierProfil')" value="modifier profil">
								<input type="button" name="annulerChangement" id="annulerChangement" onclick="modifierApparition(); showHide('sauvgarderChangement'); showHide('modifierProfil'); showHide('annulerChangement')" value="annuler changement">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="right" id="pictureContener">
				<?php 
					$Picture_tab = $bdd->query('SELECT IdImg, ImgFile FROM Image WHERE IdAccount='.$User['IdAccount'].' ORDER BY IdImg');
					if($Picture=$Picture_tab->fetch()){
						do{
							echo '<div class="pictureContener" id="img'.$Picture["IdImg"].'">';
							echo "<img class='poubelle' src='img/annuler2.png' onclick=\"rmPicture(".$Picture['IdImg'].",".$target.")\" onmouseover=\"this.src='img/annuler.png'\" onmouseout=\"this.src='img/annuler2.png'\"/>";
							echo '<img src="img/'.$User['IdAccount'].'/'.$Picture["ImgFile"].'"/>
								</div>';
						}while($Picture=$Picture_tab->fetch());
					}
				?>
				<div id="nopicture" class="pictureContener" onclick="showHide('addPictureContener')">
					<svg class="plus" viewBox="0 0 100 100">
						<path class="linePlus top" d="m 10 50 l 80 0" />
						<path class="linePlus bottom" d="m 50 10 l 0 80 " />
					</svg>
				</div>
			</div>
			<div id="addPictureContener" class="formCenter">
				<div id="formPicture">
					<h3>Ajouter une photo dans la galerie</h3>
					<div class="button" onclick="getPicture()">
						<div>Importer une photo</div>
						<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
						<input type="file" name="picture" id="picture" value="Importer une photo" accept="image/*" onchange="newPicture(<?php if(isset($_POST['target'])){ echo $target;}?>)">
					</div>
					<div class="button lastButton" onclick="showHide('addPictureContener')">
						<div>Annuler</div>
					</div>
				</div>
			</div>
			<div class="right" id="modifierHide">
				<h2>Informations :</h2>
				<div id="result"></div>
				<form id="profil" method="post">
					<div class="blocDInfos">
						<?php if(isset($_POST['target'])){ echo '<input type="text" name="target" style="display: none" value="'.$target.'"/>';}?>
						<label for="pseudo">Pseudo : </label>
						<input type="text" name="pseudo" id="pseudo" value="<?php echo $User['Pseudo'] ?>" required><br>
						<label for="name">Nom :</label>
						<input type="text" name="name" id="name" value="<?php echo $User['Name'] ?>" required><br>
						<label for="firstName">Prenom :</label>
						<input type="text" name="firstName" id="firstName" value="<?php echo $User['FirstName'] ?>" required><br>
						<label for="mail">Mail :</label>
						<input type="text" name="mail" id="mail" value="<?php echo $User['Mail'] ?>" required><br>
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
					<input type="button" name="sauvgarderChangement" id="sauvgarderChangement" onclick="modifyProfil(<?php if(isset($_POST['target'])){ echo $target;}?>)" value="sauvgarder changement">
				</form>
				<div>
					<div class="h3">
						<h3>Changer le mot de passe</h3><div class="traitSeparation"></div>
					</div>
					<form method="post" action="modifyMDP.php?user=<?php echo $User['Pseudo'];?>&password=<?php echo $User['Password'];?>">
						<?php if(isset($_POST['target'])){ echo '<input type="text" name="target" style="display: none" value="'.$target.'"/>';}
						else{?>
							<label for="password">Mot de passe :</label><br>
							<input type="password" name="password" id="password" maxlength="255" minlength="4"/><br>
						<?php }?>
						<label for="newPassword">Nouveau mot de passe :</label><br>
						<input type="password" name="newPassword" id="newPassword" maxlength="255" minlength="4"/><br>
						<label for="password_confirm">Confirmation du mot de passe :</label><br>
						<input type="password" name="password_confirm" id="password_confirm" maxlength="255" minlength="4"/><br>
						<input type="submit" name="Ajouter" value="Changer">
					</form>
				</div>
				<div>
					<div class="h3">
						<h3>Black list</h3><div class="traitSeparation"></div>
					</div>
					<div id="profils">
						<?php
						$BlockedId_tab = $bdd->prepare('SELECT IdBlocked FROM BlackList WHERE IdAccount = :idaccount ORDER BY IdBlocked');
						$BlockedId_tab->execute(array('idaccount'=>$User['IdAccount']));
						while($BlockedId=$BlockedId_tab->fetch()){
							$Blocked_tab = $bdd->prepare('SELECT Pseudo, ProfilPictureFile FROM Account WHERE IdAccount=:idcontact');
							$Blocked_tab->execute(array('idcontact'=>$BlockedId['IdBlocked']));
							if($Blocked=$Blocked_tab->fetch()){?>
								<div class="profilBlockeds" id="<?php echo $Blocked['Pseudo'];?>" onclick="unBlock(<?php echo "'".$Blocked['Pseudo']."'"; if(isset($_POST['target'])){ echo ", '".$target."'";}?>)">
									<img class="profilPicture" src="img/<?php echo $BlockedId['IdBlocked']."/".$Blocked['ProfilPictureFile'];?>">
									<div><?php echo $Blocked['Pseudo']; ?></div>
									<svg class="croix" viewBox="0 0 100 100">
										<path class="line top" d="m 10 10 l 80 80" />
										<path class="line bottom" d="m 10 90 l 80 -80 " />
									</svg>
								</div>
							<?php }
						}
						?>
					</div>
				</div>
			</div>
		</div>
	<?php }
	else{
		header('Location: /');
	}
}
else{
	header('Location: /');
}?>
