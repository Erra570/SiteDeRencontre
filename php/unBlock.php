<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}


if(isset($_SESSION['password']) AND isset($_SESSION['user']) AND isset($_POST['reciver'])){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$reciverid = htmlspecialchars($_POST['reciver']);
	$load = false;
	$target = 0;
	if(isset($_POST['target'])){
		$target = htmlspecialchars($_POST['target']);
		$Admin_tab = $bdd->prepare('SELECT IdAccount,Pseudo,Password FROM Account WHERE Pseudo=:user AND Password=:password AND IdAccount IN (SELECT IdAccount FROM Admin)');
		$Admin_tab->execute(array('user'=>$user, 'password'=>$password));
		$User_tab = $bdd->prepare('SELECT * FROM Account WHERE IdAccount=:idaccount');
		$User_tab->execute(array('idaccount'=>$target));
		$load = $User=$User_tab->fetch() AND $Admin=$Admin_tab->fetch();
	}
	else{
		$User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
		$User_tab->execute(array('user'=>$user, 'password'=>$password));
		$load = $User=$User_tab->fetch();
	}
	if($load){?>
		<?php 
		$Contact_tab = $bdd->prepare('SELECT IdAccount FROM Account WHERE Pseudo=:idcontact');
		$Contact_tab->execute(array('idcontact'=>$reciverid));
		if($Contact=$Contact_tab->fetch()){
			$reciver = $Contact['IdAccount'];
			$request = $bdd->prepare('DELETE FROM BlackList WHERE IdAccount=:idaccount AND IdBlocked=:idcontact');
			$request->execute(array('idaccount'=>$User["IdAccount"], 'idcontact'=>$reciver));
		}
	}
}
?>
