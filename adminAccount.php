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
	$User_tab = $bdd->prepare('SELECT IdAccount,Pseudo,Password FROM Account WHERE Pseudo=:user AND Password=:password AND IdAccount IN (SELECT IdAccount FROM Admin)');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	if($User=$User_tab->fetch()){ ?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>Admin</title>
				<?php include('php/head.html');?>
				<link rel="stylesheet" type="text/css" href="css/admin.css" media="all" />
				<script type="text/javascript" src="js/admin.js"></script>
				<script type="text/javascript" src="js/profil.js"></script>
			</head>
			<body onload="loadProfil()">
				<?php include("php/bandeau.html"); ?>
				<div class="contener">
					<h1>Bienvenue dans la partie Administrateur</h1>
					<div>
						<div>
							Selectionner un compte à modifier ou supprimer.
							<select name="user" id="user" onchange="loadProfil()" required>
								<?php
								$User_tab = $bdd->query('SELECT IdAccount, Pseudo, FirstName, Name FROM Account ORDER BY IdAccount');
								while($User=$User_tab->fetch()){
									echo '<option value="'.$User['IdAccount'].'">'.$User['Pseudo'].' ('.$User['Name'].' '.$User['FirstName'].')</option>';
								}
								?>
							</select>
						</div>
						<div>
							Profil de l'utilisateur : 
							<div id="profil">
							</div>
						</div>
					</div>
				<div>
			</body>
		</html>
	<?php }
	else{header('Location: /');}
}
else{header('Location: /');}?>
