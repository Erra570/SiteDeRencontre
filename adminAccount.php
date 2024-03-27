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
	$User_tab = $bdd->prepare('SELECT IdAccount,Pseudo,Password FROM Account WHERE Pseudo=:user AND Password=:password AND IdAccount IN (SELECT IdAccount FROM Admin)');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	if($User=$User_tab->fetch()){ ?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>Admin</title>
				<?php include('head.html');?>
			</head>
			<body>
				<h1>Bienvenue dans la partie Administrateur</h1>
				<div>
					<div>
						Selectionner un compte a modifier/supprimer
						<select name="user" id="user" required>
							<?php
							$User_tab = $bdd->query('SELECT IdAccount, Pseudo, FirstName, Name FROM Account ORDER BY IdAccount');
							while($User=$User_tab->fetch()){
								echo '<option value="'.$User['IdAccount'].'">'.$User['Pseudo'].' ('.$User['Name'].' '.$User['FirstName'].')</option>';
							}
							?>
						</select>
					</div>
					<div>
						Profile de l'utilisateur : 
					</div>
				</div>
			</body>
		</html>
	<?php }
	else{header('Location: /');}
}
else{header('Location: /');}?>
