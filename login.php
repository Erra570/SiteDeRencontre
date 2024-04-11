<!DOCTYPE html>
<html>
	<head>
                <?php include('php/head.html');?>
                <link rel="stylesheet" type="text/css" href="css/login.css" media="all" />
	</head>
	<body>
                <?php include('php/header.php') ?>
                
                <div class="centre">
                        <div id="titreLogin">
                                <h1> Connectez-vous à votre compte </h1>
                        </div>

                        <form class="form" id="formConnexion" method="post" action="php/verificationConnexion.php">
                                <label for="user"> Pseudo ou adresse mail :</label> <br>
                                <input class="inputText" type="text" name="user" id="user" maxlength="255" required/> <br>

                                <label for="password">Mot de passe :</label> <br>
                                <input class="inputText" type="password" name="password" id="password" maxlength="255" minlength="6" required/> <br>

                                <input class="bouton" type="submit" name="connexion" value="se connecter"/> <br>
                        </form>

                        <?php
                                if (isset($_GET["erreur"])) {
                                        echo "<p> <b>" . $_GET["erreur"] . "</b> </p>";
                                }
                        ?>
                            
                        
                        <br> <br>  
                        <a href=inscription.php> <i style="font-size: 12px;"> Pas de compte ? créez en un> </i> </a>   
                </div>

                <?php include('php/footer.php'); ?>
                
	</body>
</html>