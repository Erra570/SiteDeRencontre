<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}

if (isset($_SESSION['user']) AND isset($_SESSION['password'])){
    $user = htmlspecialchars($_SESSION['user']);
    $password = htmlspecialchars($_SESSION['password']);

	$estAdmin = $bdd->prepare('SELECT IdAccount,Pseudo,Password FROM Account WHERE Pseudo=:user AND Password=:password AND IdAccount IN (SELECT IdAccount FROM Admin)');
	$estAdmin->execute(array('user'=>$user, 'password'=>$password));

    $estAbonne = $bdd->prepare('SELECT IdAccount,Pseudo,Password FROM Account WHERE Pseudo=:user AND Password=:password AND IdAccount IN (SELECT IdAccount FROM Subscription)');
	$estAbonne->execute(array('user'=>$user, 'password'=>$password));

    if ($test=$estAdmin->fetch()) { ?>
        <!DOCTYPE html>
        <html>
            <div class="bandeau">
                <div class ="logo"><a href="index.php"><img src="img/logo.png", width = 100%></a></div>
                <a href="index.php">Accueil</a></li>
                <a href="recherche.php">Recherche</a></li>
                <a href="messagerie.php">Messagerie</a></li>
                <a href="admin.php">Gestion</a></li>
                <a href="profil.php"><?php echo "$user (admin)"; ?></a></li>
                <a href="deconnexion.php"> Se déconnecter </a></li>
            </div>
    <?php } else if ($test=$estAbonne->fetch()) { ?>
            <div class="bandeau">
                    <div class ="logo"><a href="index.php"><img src="img/logo.png", width = 100%></a></div>
                    <a href="index.php">Accueil</a></li>
                    <a href="recherche.php">Recherche</a></li>
                    <a href="messagerie.php">Messagerie</a></li>
                    <a href="profil.php"><?php echo $user; ?></a></li>
                    <a href="deconnexion.php"> Se déconnecter </a></li>
            </div>
    <?php } else { ?>
            <div class="bandeau">
                <div class ="logo"><a href="index.php"><img src="img/logo.png", width = 100%></a></div>
                <a href="index.php">Accueil</a></li>
                <a href="subscription.php">Abonnements</a></li>
                <a href="recherche.php">Recherche</a></li>
                <a href="profil.php"><?php echo $user; ?></a></li>
                <a href="deconnexion.php"> Se déconnecter </a></li>
            </div>
    <?php } 
    } else { ?>
            <div class="bandeau">
                <div class ="logo"><a href="index.php"><img src="img/logo.png", width = 100%></a></div>
                <a href="index.php">Accueil</a></li>
                <a href="login.php">Connexion</a></li>
            </div>
        </html>
    </html>
<?php }


