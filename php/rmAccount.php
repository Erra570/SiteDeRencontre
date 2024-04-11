<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}


if(isset($_SESSION['password']) AND isset($_SESSION['user']) AND isset($_POST['target'])){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$target = htmlspecialchars($_POST['target']);
	$Admin_tab = $bdd->prepare('SELECT IdAccount,Pseudo,Password FROM Account WHERE Pseudo=:user AND Password=:password AND IdAccount IN (SELECT IdAccount FROM Admin)');
	$Admin_tab->execute(array('user'=>$user, 'password'=>$password));
	$User_tab = $bdd->prepare('SELECT IdAccount FROM Account WHERE IdAccount=:idaccount');
	$User_tab->execute(array('idaccount'=>$target));

	if($User=$User_tab->fetch() AND $Admin=$Admin_tab->fetch()){
		$request = $bdd->prepare('DELETE FROM Account WHERE IdAccount = :idaccount');
		$request->execute(array('idaccount'=>$User['IdAccount']));
		shell_exec('rm -R '.__DIR__.'/../img/'.$User['IdAccount']);
	}
}
?>