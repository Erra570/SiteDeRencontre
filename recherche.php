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
    
    if ($User = $User_tab->fetch()) {
        include("php/header.php");
        include("php/head.html");
        
        if (isset($_POST['search_user'])) {
            $search_user = htmlspecialchars($_POST['search_user']);
        
            $sql = "SELECT * FROM Account WHERE Pseudo LIKE '%$search_user%' OR Name LIKE '%$search_user%' OR FirstName LIKE '%$search_user%'";
        
            $result = $bdd->query($sql);
				
            if ($result->rowCount() > 0) {
                echo "<h2>Résultats de la recherche :</h2>";
                echo "<ul>";
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<li>Nom d'utilisateur: " . $row["Pseudo"]. "</li>";
                }
                echo "</ul>";
            } else {
                echo "Aucun résultat trouvé.";
            }
        }
    } else {
        echo "Erreur d'authentification.";
    }
} else {
    echo "Veuillez vous connecter.";
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/recherche.css" media="all" />
	</head>
	<body>
		<form method="post" class="form">
    		<label for="search_user">Rechercher un utilisateur :</label>
    		<input type="text" name="search_user" id="search_user">
    		<input type="submit" value="Rechercher">
		</form>
	</body>
</html>
