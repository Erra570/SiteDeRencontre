<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}

if(isset($_SESSION['password']) AND isset($_SESSION['user']) AND isset($_POST['id'])){

	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$id = htmlspecialchars($_POST['id']);

	$User_tab = $bdd->prepare('SELECT IdAccount FROM Account WHERE Pseudo=:user AND Password=:password');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));

	if($User=$User_tab->fetch()){
		$request = $bdd->prepare('INSERT INTO Contact (IdAsker, IdAccount) VALUES (:idasker, :id)');
		$request->execute(array('idasker'=>$User['IdAccount'], 'id'=>$id));
	}
}
?>