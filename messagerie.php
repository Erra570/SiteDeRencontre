<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}


/*a supprimer a terme*/
if(isset($_GET['password']) AND isset($_GET['user'])){
	$_SESSION['user'] = htmlspecialchars($_GET['user']);
	$_SESSION['password'] = htmlspecialchars($_GET['password']);
}

if(isset($_SESSION['password']) AND isset($_SESSION['user'])){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	if($User=$User_tab->fetch()){ ?>
		<!DOCTYPE html>
		<html>
			<head>
				<?php include('php/head.html');?>
				<link rel="stylesheet" type="text/css" href="css/messagerie.css" media="all" />
				<script type="text/javascript" src="js/messagerie.js"></script>
			</head>
			<body onload="entree('<?php if(isset($_POST['target'])){ echo $target;}?>')">
				<?php include("php/bandeau.html"); ?>
				<div class="centreur">
					<div id="left">
						<div>
							Discutions
							<?php 
							$first = 0;
							$ContactId_tab = $bdd->prepare('SELECT IdAsker, IdAccount FROM Contact WHERE (IdAccount = :idaccount OR IdAsker = :idaccount) AND Approval=1 ORDER BY IdAccount');
							$ContactId_tab->execute(array('idaccount'=>$User['IdAccount']));
							while($ContactId=$ContactId_tab->fetch()){
								$idcontact = $ContactId['IdAccount'];
								if($ContactId['IdAsker'] != $User['IdAccount']){
									$idcontact = $ContactId['IdAsker'];
								}

								if($first == 0){
									$first = $idcontact;
								}

								$Contact_tab = $bdd->prepare('SELECT Pseudo, ProfilPictureFile FROM Account WHERE IdAccount=:idcontact');
								$Contact_tab->execute(array('idcontact'=>$idcontact));
								if($Contact=$Contact_tab->fetch())
								?>
								<div class="profil">
									<img class="profilPicture" src="img/<?php echo $idcontact."/".$Contact['ProfilPictureFile'];?>">
									<div><?php echo $Contact['Pseudo']; ?></div>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php 
					$Contact_tab = $bdd->prepare('SELECT Pseudo, ProfilPictureFile FROM Account WHERE IdAccount=:idcontact');
					$Contact_tab->execute(array('idcontact'=>$first));
					if($Contact=$Contact_tab->fetch()){
						?>
						<div class="right" id="modifierHide">
							<div class="msgTop">
								<a class="msgTopLeft" href="profilPublic.php?user=<?php echo $Contact['Pseudo'];?>">
									<img class="profilPicture" src="img/<?php echo $idcontact."/".$Contact['ProfilPictureFile'];?>">
									<h2 id="Reciver"><?php echo $Contact['Pseudo'];?></h2>
								</a>
								<div class="msgTopRight">
									<svg class="petitPoints" viewBox="0 0 100 100">
										<circle r="5" cx="50" cy="25" fill="#b1b1b1" />
										<circle r="5" cx="50" cy="50" fill="#b1b1b1" />
										<circle r="5" cx="50" cy="75" fill="#b1b1b1" />
									</svg>
								</div>
							</div>
							<div class="msgBody">
								<div id="msgContener">
								</div>
								<div class="msgWriter">
									<input type="text" name="msgToSend" id="msgToSend">
								</div>
							</div>
						</div>
					<?php }?>
				</div>
			</body>
		</html>
	<?php }
	else{header('Location: /');}
}
else{header('Location: /');}?>
