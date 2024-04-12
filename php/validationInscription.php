<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8', 'User', 'fv_7qJ6j2_VY_T5', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['Inscription'])) {
    $user = htmlspecialchars($_POST['user']);
    $password = htmlspecialchars($_POST['password']);
    $mail = htmlspecialchars($_POST['mail']);

    $User_tab = $bdd->prepare('SELECT Pseudo,Password FROM Account WHERE (Pseudo=:user OR Mail=:mail) AND Password=:password');
    $User_tab->execute(array('user'=>$user, 'mail'=>$mail, 'password'=>$password));

    $User2_tab = $bdd->prepare('SELECT Pseudo,Password FROM Account WHERE (Pseudo=:user OR Mail=:mail)');
    $User2_tab->execute(array('user'=>$user, 'mail'=>$mail));

    if ($User = $User_tab->fetch()) {
        $_SESSION['user'] = $User['IdAccount'];
        $_SESSION['password'] = $password;
        header("Location: ../index.php");
    }
    else if($User = $User2_tab->fetch()){
        header("Location: ../inscription.php?erreur=existe");
    }
    else {
        $_SESSION['user'] = $user;
        $_SESSION['password'] = $password;

        $pseudo = htmlspecialchars($_POST['user']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $nom = htmlspecialchars($_POST['nom']);
        $password = htmlspecialchars($_POST['password']);
        $date_de_naissance = htmlspecialchars($_POST['date_de_naissance']);
        $species = htmlspecialchars($_POST['Species']);
        $sexe = htmlspecialchars($_POST['Sexe']);
        $country = htmlspecialchars($_POST['contry']);
        $city = htmlspecialchars($_POST['city']);
        $street = htmlspecialchars($_POST['street']);

        $query = 'INSERT INTO Account (Pseudo, Password, Sexe, FirstName, Name, Mail, DateOfBirth, Country, City, Street) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $User = $bdd->prepare($query);

        $User->execute([$pseudo, $password, $sexe, $prenom, $nom, $mail, $date_de_naissance, $country, $city, $street]);
        $User_tab = $bdd->query("SELECT IdAccount FROM Account WHERE Pseudo = '".$pseudo."'");
        $NewUser=$User_tab->fetch();

        shell_exec('cp -R '.__DIR__.'/../img/0 '.__DIR__.'/../img/'.$NewUser['IdAccount']);

        header('Location: ../profil.php');
    }
 } 


