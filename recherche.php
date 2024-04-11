<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}


if(isset($_SESSION['password']) AND isset($_SESSION['user']) ){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$reciverid = htmlspecialchars($_POST['reciver']);
	$User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	if($User=$User_tab->fetch()){?>
		<?php include("php/bandeau.html"); ?>
		<?php include("php/head.html"); ?>
		<?php
		if(isset($_GET['search_user'])) {

			$search_user = $_GET['search_user'];
		
			$sql = "SELECT * FROM Account WHERE Pseudo LIKE '%$search_user%' OR Name LIKE '%$search_user%' OR FirstName LIKE '%$search_user%'";
		
			$result = $conn->query($sql);
		
			if ($result->num_rows > 0) {
				echo "<h2>Résultats de la recherche :</h2>";
				echo "<ul>";
				while($row = $result->fetch_assoc()) {
					echo "<li>Nom d'utilisateur: " . $row["nom_utilisateur"]. "</li>";
				}
				echo "</ul>";
			} else {
				echo "Aucun résultat trouvé.";
			}
		}
		

	

	} else {
		echo 2;
	}
} else {
	echo 1;
}
?>
<form method="post" class="form">
    <label for="search_user">Rechercher un utilisateur :</label>
    <input type="text" name="search_user" id="search_user">
    <input type="submit" value="Rechercher">
</form>