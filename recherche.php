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
                <?php include("php/head.html"); ?>
                <link rel="stylesheet" type="text/css" href="css/recherche.css" media="all" />
            </head>
            <body>
                <?php include("php/header.php"); ?>
                <div id="contener">
                    <div id="percent">
                        <form method="post" class="form">
                            <div>
                                <label for="search_user">Rechercher un utilisateur :</label>
                                <input type="text" name="search_user" id="search_user">
                                <input type="submit" value="Rechercher"><br>
                            </div>
                            <div>
                                <label for="Sexe"> Sexe : </label>
                                <input type="checkbox" name="M" id="M" checked><label for="M">masculin</label>
                                <input type="checkbox" name="F" id="F" checked><label for="F">feminin</label> 
                                <input type="checkbox" name="A" id="A" checked><label for="A">autre</label>

                                <label for="Sexe"> Age : </label>
                                <input type="number" name="minAge" id="minAge" min="0" max="1000"><label for="minAge">min</label>
                                <input type="number" name="maxAge" id="maxAge" min="0" max="1000"/><label for="maxAge">max</label>

                                <label for="love">Situation amoureuse : </label>
                                <input type="checkbox" name="love" id="C" value="Celibataire" checked><label for="M">Celibataire</label>
                                <input type="checkbox" name="love" id="E" value="En couple" checked><label for="F">En couple</label> 
                                <input type="checkbox" name="love" id="D" value="Divorce" checked><label for="A">Divorce</label>

                                <label for="Sexe">Humain : </label>
                                <input type="number" name="minHumain" id="minHumain" min="0" max="10"><label for="minHumain">min</label>
                                <input type="number" name="maxHumain" id="maxHumain" min="0" max="10"/><label for="maxHumain">max</label>
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['search_user'])) {
                            $search_user = htmlspecialchars($_POST['search_user']);
                            $sql = "SELECT * FROM Account WHERE (Pseudo LIKE '%$search_user%' OR Name LIKE '%$search_user%' OR FirstName LIKE '%$search_user%') AND IdAccount <> ".$User['IdAccount']." ORDER BY rand()";
                        }
                        else{
                            $sql = "SELECT * FROM Account WHERE IdAccount <> ".$User['IdAccount']." ORDER BY rand()";
                        }
                    
                    
                        $result = $bdd->query($sql);
            				
                        if ($result->rowCount() > 0) { ?>
                            <h2>Résultats de la recherche :</h2>
                            <div id="profils">
                                <?php
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <a class="profil" href="profilPublic.php?currentUser=<?php echo $row['Pseudo']; ?>">
                                        <img class="profilPicture" src="img/<?php echo $row['IdAccount']."/".$row['ProfilPictureFile'];?>">
                                        <div class="pseudo"><?php echo $row['Pseudo']; ?></div>
                                        <div class="pseudo"><?php echo $row['FirstName']; ?></div>
                                        <div class="pseudo"><?php echo $row['Name']; ?></div>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php
                        } else {
                            echo "Aucun résultat trouvé.";
                        } ?>
                    </div>
                </div>
            </body>
        </html>
    <?php
    } 
    else{header('Location: /');}
}
else{header('Location: /');}
?>