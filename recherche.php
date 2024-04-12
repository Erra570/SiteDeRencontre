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
    
    if($User = $User_tab->fetch()){ ?>

        <!DOCTYPE html>
        <html>
            <head>
                <?php include("php/head.html"); ?>
                <link rel="stylesheet" type="text/css" href="css/recherche.css" media="all" />
				<script src="js/recherche.js"></script>
            </head>
            <body>
                <?php include("php/header.php"); ?>	
                <div id="contener">
                    <div id="percent">
						<button id="moreButton">Filtres</button>
                        <form method="post" class="form">
                            <div>
                                <label for="search_user">Rechercher un utilisateur :</label>
                                <input type="text" name="search_user" id="search_user">
                                <input type="submit" id="submit" value="Rechercher"><br>
                            </div>
                            <div id="formMore" style="display: none;">
                                <label for="Sexe"> Sexe : </label>
								<label for="M">masculin</label>
                                <input type="checkbox" name="M" id="M" <?php if(isset($_POST['M']) OR !isset($_POST['search_user'])){ echo "checked";} ?>>
                                <label for="F">feminin</label>
								<input type="checkbox" name="F" id="F" <?php if(isset($_POST['F']) OR !isset($_POST['search_user'])){ echo "checked";} ?>> 
                                <label for="A">autre</label>
								<input type="checkbox" name="A" id="A" <?php if(isset($_POST['A']) OR !isset($_POST['search_user'])){ echo "checked";} ?>>
								<br>
                                <label for="Age"> Age : </label>
								<label for="minAge">min</label>
                                <input type="number" name="minAge" id="minAge" min="0" max="10000" value="<?php if(isset($_POST['minAge'])){echo htmlspecialchars($_POST['minAge']);} ?>">
                                <label for="maxAge">max</label>
                                <input type="number" name="maxAge" id="maxAge" min="0" max="10000" value="<?php if(isset($_POST['maxAge'])){echo htmlspecialchars($_POST['maxAge']);} ?>">
                                <br>

                                <label for="love">Situation amoureuse : </label>
								<label for="M">Celibataire</label>
                                <input type="checkbox" name="C" id="C" value="Celibataire" <?php if(isset($_POST['C']) OR !isset($_POST['search_user'])){ echo "checked";} ?>>
                                <label for="F">En couple</label>
                                <input type="checkbox" name="E" id="E" value="En couple" <?php if(isset($_POST['E']) OR !isset($_POST['search_user'])){ echo "checked";} ?>>
								<label for="A">Divorce</label>
                                <input type="checkbox" name="D" id="D" value="Divorce" <?php if(isset($_POST['D']) OR !isset($_POST['search_user'])){ echo "checked";} ?>>
                                
								<br>
                                <label for="Humain">Humain : </label>
								<label for="minHumain">min</label>
                                <input type="number" name="minHumain" id="minHumain" min="0" max="10" value="<?php if(isset($_POST['minHumain'])){echo htmlspecialchars($_POST['minHumain']);} ?>">
                                <label for="maxHumain">max</label>
                                <input type="number" name="maxHumain" id="maxHumain" min="0" max="10" value="<?php if(isset($_POST['maxHumain'])){echo htmlspecialchars($_POST['maxHumain']);} ?>">
                                
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['search_user'])) {
                            $search_user = htmlspecialchars($_POST['search_user']);
                            $sql = "SELECT IdAccount, Pseudo, FirstName, Name, ProfilPictureFile FROM Account WHERE (Pseudo LIKE '%$search_user%' OR Name LIKE '%$search_user%' OR FirstName LIKE '%$search_user%') AND";

                            if(!isset($_POST['M'])){
                                $sql = $sql." Sexe <> 'M' AND";
                            }
                            if(!isset($_POST['F'])){
                                $sql = $sql." Sexe <> 'F' AND";
                            }
                            if(!isset($_POST['A'])){
                                $sql = $sql." Sexe <> 'A' AND";
                            }

                            if(isset($_POST['minAge']) && htmlspecialchars($_POST['minAge'])!=''){
                                $sql = $sql.' DATEDIFF(current_timestamp(), DateOfBirth)/365 >= '.htmlspecialchars($_POST['minAge']).' AND';
                            }
                            if(isset($_POST['maxAge']) && htmlspecialchars($_POST['maxAge'])!=''){
                                $sql = $sql.' DATEDIFF(current_timestamp(), DateOfBirth)/365 <= '.htmlspecialchars($_POST['maxAge']).' AND';
                            }

                            if(!isset($_POST['C'])){
                                $sql = $sql." LoveSituation <> 'Celibataire' AND";
                            }
                            if(!isset($_POST['E'])){
                                $sql = $sql." LoveSituation <> 'En couple' AND";
                            }
                            if(!isset($_POST['D'])){
                                $sql = $sql." LoveSituation <> 'Divorce' AND";
                            }

                            if(isset($_POST['minHumain']) && htmlspecialchars($_POST['minHumain'])!=''){
                                $sql = $sql.' HumanoidGauge >= '.htmlspecialchars($_POST['minHumain']).' AND';
                            }
                            if(isset($_POST['maxHumain']) && htmlspecialchars($_POST['maxHumain'])!=''){
                                $sql = $sql.' HumanoidGauge <= '.htmlspecialchars($_POST['maxHumain']).' AND';
                            }
                            $sql = $sql." IdAccount <> ".$User['IdAccount']." ORDER BY rand()";
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
                <?php include("php/footer.html"); ?>
            </body>
        </html>
    <?php }
    else{header('Location: /');}
}
else{header('Location: /');}
?>