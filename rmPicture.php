<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exeption $e){
	die('Erreur : '.$e->getMessage());
}

//if(isset($_SESSION['password']) AND isset($_SESSION['user'])){
if(isset($_GET['password']) AND isset($_GET['user']) AND isset($_POST['idimg'])) {
	$user = htmlspecialchars($_GET['user']);
	$password = htmlspecialchars($_GET['password']);
	$idimg = htmlspecialchars($_POST['idimg']);
	$User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	if($User=$User_tab->fetch()){ 
		$request = $bdd->prepare('DELETE FROM Image WHERE IdAccount = :idaccount AND IdImg = :idimg');
		$request->execute(array('idaccount'=>$User['IdAccount'], 'idimg'=>$idimg));
		echo $User['IdAccount']."/ProfilDefaultPicture.png";
	}
	else{echo ("2");}
}
else{echo ("1");}?>