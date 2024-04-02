<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}

if(isset($_SESSION['password']) AND isset($_SESSION['user']) AND isset($_FILES['picture'])){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$load = false;
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
	if($load){
		$Nom_fichier=$_FILES['picture']['name'];
		$path_f=pathinfo($Nom_fichier);
		$Extension_fichier=$path_f['extension'];
		$Extension_autorisée=array('png','jpg','jpeg','webp');
		if (in_array($Extension_fichier, $Extension_autorisée)){
			if(move_uploaded_file($_FILES['picture']['tmp_name'],__DIR__."/../img/".$User['IdAccount']."/".$Nom_fichier)) {
				$tab_idmax = $bdd->prepare('SELECT MAX(IdImg) AS m FROM Image WHERE IdAccount=:idaccount');
				$tab_idmax->execute(array('idaccount'=>$User['IdAccount']));
				$idimg = 1;
				if($idmax=$tab_idmax->fetch()){
					$idimg = $idmax['m']+1;
				}
				$request = $bdd->prepare('INSERT INTO Image (IdAccount, IdImg, ImgFile) VALUES (:idaccount, :idimg, :nomimg)');
				$request->execute(array('idaccount'=>$User['IdAccount'], 'idimg'=>$idimg, 'nomimg'=>$Nom_fichier));
				echo $idimg."&".$User['IdAccount']."/".$Nom_fichier;
			}
		}
	}
}?>