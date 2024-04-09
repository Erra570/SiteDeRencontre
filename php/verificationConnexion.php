<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}

if (isset($_POST['user']) && isset($_POST['password'])) {
    $user = htmlspecialchars($_POST['user']);
    $password = htmlspecialchars($_POST['password']);
    $User_tab = $bdd->prepare('SELECT Pseudo,Password FROM Account WHERE (Pseudo=:user OR Mail=:user) AND Password=:password');
    $User_tab->execute(array('user'=>$user, 'password'=>$password));
    $User = $User_tab->fetch();

    if ($User) {
        header("Location: ../index.php");
        exit();
    } else {
        header('Location: ../login.php?erreur=Identifiant ou mot de passe incorrect');
    }
}
?>