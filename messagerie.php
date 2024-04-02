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
				<?php include('head.html');?>
				<link rel="stylesheet" type="text/css" href="css/profil.css" media="all" />
				<script type="text/javascript" src="js/profil.js"></script>
			</head>
			<body>
				<?php include("bandeau.html"); ?>
				<div class="centreur">
					<div id="left">
						<div>
							<?php 
							$ContactId_tab = $bdd->prepare('SELECT IdAsker, IdAccount FROM Contact WHERE (IdAccount = :idaccount OR IdAsker = :idaccount) AND Approval ORDER BY IdAccount');
							$ContactId_tab->execute(array('user'=>$user, 'password'=>$password));
							while($ContactId=$ContactId_tab->fetch()){
								$Contact_tab = $bdd->prepare('SELECT Pseudo, ProfilPictureFile FROM Account WHERE IdAccount=:idcontact');
								$Contact_tab->execute(array('idcontact'=>$ContactId));
								if($Contact=$Contact_tab->fetch())
								?>
								<div>
									<img src="img/<?php echo $Contact['ProfilPictureFile'];?>">
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<div class="right" id="modifierHide">
						
					</div>
				</div>
			</body>
		</html>
	<?php }
	else{header('Location: /');}
}
else{header('Location: /');}?>
