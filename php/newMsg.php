<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}
if(isset($_SESSION['password']) AND isset($_SESSION['user']) AND isset($_POST['reciver']) AND isset($_POST['content'])){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$reciver = htmlspecialchars($_POST['reciver']);
	$content = htmlspecialchars($_POST['content']);
	$load = false;
	if(isset($_POST['target'])){
		$target = htmlspecialchars($_POST['target']);
		$Admin_tab = $bdd->prepare('SELECT IdAccount FROM Account WHERE Pseudo=:user AND Password=:password AND IdAccount IN (SELECT IdAccount FROM Admin)');
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

	$Reciver_tab = $bdd->prepare('SELECT IdAccount FROM Account WHERE Pseudo=:user');
	$Reciver_tab->execute(array('user'=>$reciver));
	$load = $load && $Reciver=$Reciver_tab->fetch();
	
	if($load){
		$Contact_tab = $bdd->prepare('SELECT IdAsker, IdAccount FROM Contact WHERE ((IdAccount = :idaccount1 AND IdAsker = :idaccount2) OR (IdAccount = :idaccount2 AND IdAsker = :idaccount1)) AND Approval=1 AND 
			IdAsker not in (SELECT IdAccount FROM BlackList WHERE IdBlocked = :idaccount1) AND 
			IdAsker not in (SELECT IdBlocked FROM BlackList WHERE IdAccount = :idaccount1) AND 
			IdAccount not in (SELECT IdAccount FROM BlackList WHERE IdBlocked = :idaccount1) AND 
			IdAccount not in (SELECT IdBlocked FROM BlackList WHERE IdAccount = :idaccount1)');
		$Contact_tab->execute(array('idaccount1'=>$User['IdAccount'], 'idaccount2'=>$Reciver['IdAccount']));
		if($Contact=$Contact_tab->fetch()){
			$request = $bdd->prepare('INSERT INTO Message (IdSender, IdRecipient, Content) VALUES (:idsender, :idreciver, :content)');
			$request->execute(array('idsender'=>$User['IdAccount'], 'idreciver'=>$Reciver['IdAccount'], 'content'=>$content));
		}
	}
}
?>