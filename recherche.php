<?php 
session_start(); 

try {
    $bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : '.$e->getMessage());
}

if (isset($_SESSION['password']) && isset($_SESSION['user'])) {
    $user = htmlspecialchars($_SESSION['user']);
    $password = htmlspecialchars($_SESSION['password']);
    
    $User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
    $User_tab->execute(array('user' => $user, 'password' => $password));
    
    if ($User = $User_tab->fetch()) { ?>

        <!DOCTYPE html>
        <html>
            <head>
                <?php include("php/header.php"); ?>
                <link rel="stylesheet" type="text/css" href="css/recherche.css" media="all" />
            </head>
            <body>
                <?php include("php/head.html"); ?>
                <div id="contener">
                    <div>
                        <form method="post" class="form">
                            <label for="search_user">Rechercher un utilisateur :</label>
                            <input type="text" name="search_user" id="search_user">
                            <input type="submit" value="Rechercher">
                        </form>
                        <?php
                        if (isset($_POST['search_user'])) {
                            $search_user = htmlspecialchars($_POST['search_user']);
                        
                            $sql = "SELECT * FROM Account WHERE Pseudo LIKE '%$search_user%' OR Name LIKE '%$search_user%' OR FirstName LIKE '%$search_user%'";
                        
                            $result = $bdd->query($sql);
                				
                            if ($result->rowCount() > 0) { ?>
                                <h2>Résultats de la recherche :</h2>
                                <a id="profils" href="profilPublic.php?currentUser=<?php echo $row['Pseudo']; ?>">
                                    <?php
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <div class="profil">
                                            <img class="profilPicture" src="img/<?php echo $row['IdAccount']."/".$row['ProfilPictureFile'];?>">
                                            <div class="pseudo"><?php echo $row['Pseudo']; ?></div>
                                            <div class="pseudo"><?php echo $row['FirstName']; ?></div>
                                            <div class="pseudo"><?php echo $row['Name']; ?></div>
                                        </div>
                                    <?php } ?>
                                </a>
                            <?php
                            } else {
                                echo "Aucun résultat trouvé.";
                            }
                        } ?>
                    </div>
                </div>
            </body>
        </html>
    <?php
    } else {
        echo "Erreur d'authentification.";
    }
} else {
    echo "Veuillez vous connecter.";
}
?>