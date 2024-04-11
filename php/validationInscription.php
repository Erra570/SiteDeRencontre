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
    $_SESSION['user'] = $user;
    $_SESSION['password'] = $password;

    $pseudo = htmlspecialchars($_POST['user']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $mail = htmlspecialchars($_POST['mail']);
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


