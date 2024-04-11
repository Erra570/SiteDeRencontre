<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}
if(isset($_SESSION['password']) AND isset($_SESSION['user']) AND isset($_POST['reciver']) AND isset($_POST['last'])){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$reciver = htmlspecialchars($_POST['reciver']);
	$last = htmlspecialchars($_POST['last']);
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
		$Msg_tab = $bdd->prepare('SELECT DATE_FORMAT(DateSend, \'%d/%m/%Y %H:%i\') AS date, DATE_FORMAT(DateSend, \'%Y-%m-%d-%H-%i-%s\') AS dateformat, Content, IdSender, IdMessage FROM Message WHERE IdSender = :idsender AND IdRecipient = :idreciver AND IdMessage > :last ORDER BY IdMessage DESC');
		$Msg_tab->execute(array('idreciver'=>$User['IdAccount'], 'idsender'=>$Reciver['IdAccount'], 'last'=>$last));
		while($Msg=$Msg_tab->fetch()){
			$_GET['IdMessage'] = $Msg['IdMessage'];
			$_GET['IdSender'] = $Msg['IdSender'];
			$_GET['IdAccount'] = $User['IdAccount'];
			$_GET['Content'] = $Msg['Content'];
			$_GET['dateformat'] = $Msg['dateformat'];
			$_GET['date'] = $Msg['date'];
			
			include('msg.php');
		}
	}
}
?>