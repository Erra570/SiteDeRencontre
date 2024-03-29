<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exeption $e){
	die('Erreur : '.$e->getMessage());
}

//if(isset($_SESSION['password']) AND isset($_SESSION['user'])){
if(isset($_GET['password']) AND isset($_GET['user']) AND isset($_FILES['profilPicture'])) {
	$user = htmlspecialchars($_GET['user']);
	$password = htmlspecialchars($_GET['password']);
	$User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	if($User=$User_tab->fetch()){ 
		$Nom_fichier=$_FILES['profilPicture']['name'];
		$path_f=pathinfo($Nom_fichier);
		$Extension_fichier=$path_f['extension'];
		$Extension_autorisée=array('png','jpg','jpeg','webp');
		if (in_array($Extension_fichier, $Extension_autorisée)){
			if(move_uploaded_file($_FILES['profilPicture']['tmp_name'],__DIR__."/img/".$User['IdAccount']."/".$Nom_fichier)) {
				$request = $bdd->prepare('UPDATE Account SET ProfilPictureFile=:nomimg WHERE IdAccount = :idaccount');
				$request->execute(array('idaccount'=>$User['IdAccount'], 'nomimg'=>$Nom_fichier));
				echo $User['IdAccount']."/".$Nom_fichier;
			}
		}
	}
}?>