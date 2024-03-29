<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exeption $e){
	die('Erreur : '.$e->getMessage());
}

//if(isset($_SESSION['password']) AND isset($_SESSION['user'])){
if(isset($_GET['password']) AND isset($_GET['user']) AND isset($_POST['password']) AND isset($_POST['newPassword']) AND isset($_POST['password_confirm'])) {
	$user = htmlspecialchars($_GET['user']);
	$password = htmlspecialchars($_GET['password']);
	$User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	if($User=$User_tab->fetch()){ 
		$passwordp = htmlspecialchars($_POST['password']);
		$newPassword = htmlspecialchars($_POST['newPassword']);
		$password_confirm = htmlspecialchars($_POST['password_confirm']);
		if($password == $passwordp && $newPassword == $password_confirm){
			$request = $bdd->prepare('UPDATE Account SET Password=:newpassword WHERE Pseudo=:user AND Password=:password');
			$request->execute(array('user'=>$user, 'password'=>$password, 'newpassword'=>$newPassword));
			header('Location: profil.php?user='.$user.'&password='.$newPassword);
		}
		else{
			header('Location: profil.php?user='.$user.'&password='.$password);
		}
	}
	else{header('Location: /');}
}
else{header('Location: /');}?>