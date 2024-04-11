<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8', 'User', 'fv_7qJ6j2_VY_T5', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['Inscription'])) {
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
    shell_exec('cp -R '.__DIR__.'/../img/0 '.__DIR__.'/../img/'.$User['IdAccount']);

    $User->execute([$pseudo, $password, $sexe, $prenom, $nom, $mail, $date_de_naissance, $country, $city, $street]);
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <?php include('head.html');?>
            <!-- à supprimer mais je peux pas faire sans sur le PC de l'école -->
            <meta charset="utf-8">
            <title>Connexion - Donjon et Passion</title>
            <link rel="icon" sizes="175x175" href="img/logo_a_modifier.jpeg">
            <link rel="stylesheet" type="text/css" href="css/login.css" media="all" />
        </head>
        <body>
            <div class=titre>
                <h1> Félicitations ! Vous pouvez désormais vous connecter : </h1>
            </div>
            <a href="login.php"> Connexion </a>
        </body>
    </html>
    <?php }


