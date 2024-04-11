<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}

if(isset($_SESSION['password']) AND isset($_SESSION['user']) AND isset($_POST['typeAbonnement']) AND isset($_POST['NumCarte']) AND isset($_POST['Titulaire']) AND isset($_POST['mois']) AND isset($_POST['annee']) AND isset($_POST['crypto'])) {
    $user = htmlspecialchars($_SESSION['user']);
    $password = htmlspecialchars($_SESSION['password']);
    $User_tab = $bdd->prepare('SELECT IdAccount FROM Account WHERE Pseudo=:user AND Password=:password');
    $User_tab->execute(array('user'=>$user, 'password'=>$password));

    if($User=$User_tab->fetch()){
        $Subscription_tab = $bdd->prepare('SELECT End FROM Subscription WHERE IdAccount=:idaccount ORDER BY End DESC');
        $Subscription_tab->execute(array('idaccount'=>$User['IdAccount']));
        if($Subscription = $Subscription_tab->fetch()){
            $request = $bdd->prepare('INSERT INTO Subscription (IdAccount, Start, End) VALUES (:idaccount, :start, DATE_ADD(:start, INTERVAL :duration MONTH))');
            $request->execute(array('idaccount'=>$User['IdAccount'], 'start'=>$Subscription['End'], 'duration'=>htmlspecialchars($_POST['typeAbonnement'])));
        }
        else{
            $request = $bdd->prepare('INSERT INTO Subscription (IdAccount, End) VALUES (:idaccount, DATE_ADD(current_timestamp(), INTERVAL :duration MONTH))');
            $request->execute(array('idaccount'=>$User['IdAccount'], 'duration'=>htmlspecialchars($_POST['typeAbonnement'])));
        }
        header('Location: /profil.php');
    }
    else{header('Location: /');}
}
else{header('Location: /');}
?>