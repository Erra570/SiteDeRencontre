<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}

if(isset($_SESSION['password']) AND isset($_SESSION['user']) AND isset($_GET['currentUser'])){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	$CurrentUser_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user');
	$CurrentUser_tab->execute(array('user'=>htmlspecialchars($_GET['currentUser'])));

	$load = true;
	$load = $load && $CurrentUser=$CurrentUser_tab->fetch();
	$load = $load && $User=$User_tab->fetch();


	if($load){ 

		?>
		<!DOCTYPE html>
		<html>
			<head>
				<?php include('php/head.html');?>
				<link rel="stylesheet" type="text/css" href="css/profil.css" media="all" />
				<script type="text/javascript" src="js/profil.js"></script>
			</head>
			<body>
				<?php include("php/header.php"); ?>
				<div id="centreur">
					<div id="profilPres">
						<div>
							<?php 
								$bouton = false;

								$estAbonne = $bdd->prepare('SELECT * FROM Account WHERE IdAccount = :idaccount AND IdAccount IN (SELECT IdAccount FROM Subscription)');
								$estAbonne->execute(array('idaccount'=>$User['IdAccount']));

								$bouton = $bouton || $est1=$estAbonne->fetch();

								$estAdmin = $bdd->prepare('SELECT * FROM Account WHERE IdAccount = :idaccount AND IdAccount IN (SELECT IdAccount FROM Admin)');
								$estAdmin->execute(array('idaccount'=>$User['IdAccount']));

								$bouton = $bouton || $est2=$estAdmin->fetch();

								$AskerId_tab = $bdd->prepare('SELECT IdAsker FROM Contact WHERE (IdAccount = :idaccount1 AND IdAsker = :idaccount2) OR (IdAccount = :idaccount2 AND IdAsker = :idaccount1)');
								$AskerId_tab->execute(array('idaccount1'=>$User['IdAccount'], 'idaccount2'=>$CurrentUser['IdAccount']));


								if(!($AskerId=$AskerId_tab->fetch()) && $bouton){ ?>
									<div id="askContact" onclick="contact(<?php echo $CurrentUser['IdAccount']; ?>)">Envoyer une demande de contact</div>
								<?php }
							?>
							<div class="centreHorizontalement" id="profilTop" onclick="showHide('modifyProfilPictureContener')">
								<img id="imgProfilPicture" src="img/<?php echo $CurrentUser['IdAccount'].'/'.$CurrentUser['ProfilPictureFile'];?>">
							</div>
							<div class="centreHorizontalement" id="profilBottom">
								<div id="contenerBas">
									<div>
										<p><?php echo $CurrentUser['Pseudo'];?></p>
									</div>
									<div>
										<p><?php if(isset($CurrentUser['Species'])){echo $CurrentUser['Species'];}?></p>
										<p><?php if(isset($CurrentUser['LoveSituation'])){echo $CurrentUser['LoveSituation'];}?></p>
									</div>
									<div>
										<p>Description :</p>
									</div>
									<div>
										<p id="description"><?php if(isset($CurrentUser['WelcomeMessage'])){echo $CurrentUser['WelcomeMessage'];}?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="right" id="pictureContener">
						<?php 
							$Picture_tab = $bdd->query('SELECT IdImg, ImgFile FROM Image WHERE IdAccount='.$CurrentUser['IdAccount'].' ORDER BY IdImg');
							if($Picture=$Picture_tab->fetch()){
								do{
									echo '<div class="pictureContener" id="img'.$Picture["IdImg"].'">';
									echo '<img src="img/'.$CurrentUser['IdAccount'].'/'.$Picture["ImgFile"].'"/>
										</div>';
								}while($Picture=$Picture_tab->fetch());
							}
						?>
					</div>
				</div>
				<?php include("php/footer.html"); ?>
			</body>
		</html>
	<?php }
	else{header('Location: /');}
}
else{header('Location: /');}?>
