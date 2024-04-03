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
			<body onload="loadChat('<?php if(isset($_POST['target'])){ echo $target;}?>');">
				<?php include("php/bandeau.html"); ?>
				<div class="centreur">
					<div id="left">
						<div id="discussionOuverte">
							<h2>Discussions</h2>
							<?php 
							$first = 0;
							$ContactId_tab = $bdd->prepare('SELECT IdAsker, IdAccount FROM Contact WHERE (IdAccount = :idaccount OR IdAsker = :idaccount) AND Approval=1 ORDER BY IdAccount');
							$ContactId_tab->execute(array('idaccount'=>$User['IdAccount']));
							while($ContactId=$ContactId_tab->fetch()){
								$idcontact = $ContactId['IdAccount'];
								if($ContactId['IdAsker'] != $User['IdAccount']){
									$idcontact = $ContactId['IdAsker'];
								}

								$Contact_tab = $bdd->prepare('SELECT Pseudo, ProfilPictureFile FROM Account WHERE IdAccount=:idcontact');
								$Contact_tab->execute(array('idcontact'=>$idcontact));
								if($Contact=$Contact_tab->fetch())
								?>
								<input type="radio" name="reciver" class="radioCache" 
									value="<?php echo $Contact['Pseudo']; ?>" 
									id="<?php echo $Contact['Pseudo']; ?>" 
									<?php if($first == 0){echo "checked"; $first = 1;}?>
									onclick="loadChat('<?php if(isset($_POST['target'])){ echo $target;}?>')">
								<label class="profil" for="<?php echo $Contact['Pseudo']; ?>">
									<img class="profilPicture" src="img/<?php echo $idcontact."/".$Contact['ProfilPictureFile'];?>">
									<div><?php echo $Contact['Pseudo']; ?></div>
								</label>
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
							
						</div>
					<?php }?>
				</div>
			</body>
		</html>
	<?php }
	else{header('Location: /');}
}
else{header('Location: /');}?>
