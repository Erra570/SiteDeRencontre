<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}


/*a supprimer a terme*/
if(isset($_GET['password']) AND isset($_GET['user'])){
	$_SESSION['user'] = htmlspecialchars($_GET['user']);
	$_SESSION['password'] = htmlspecialchars($_GET['password']);
}

if(isset($_SESSION['password']) AND isset($_SESSION['user']) AND isset($_POST['typeAbonnement'])){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	if($User=$User_tab->fetch()){ ?>
		<!DOCTYPE html>
		<html>
			<head>
				<?php include('php/head.html');?>
				<link rel="stylesheet" type="text/css" href="css/subscription.css" media="all" />
                <link rel="stylesheet" type="text/css" href="css/login.css" media="all" />
			</head>
			<body>
				<?php include("php/header.php"); ?>
				<div class="centre">
					<div id="contener">
						<h2>Paiement</h2>
						<form method="post" action="php/verificationSubscriptionPayment.php">
							<input type="radio" name="typeAbonnement" value="<?php echo $_POST['typeAbonnement']; ?>" checked style="display: none;">
							<div class="droit">
	                            <label for="NumCarte">Numéro de la carte</label> <br>
	                            <input class="inputText" type="text" name="NumCarte" id="NumCarte" minlength="16" maxlength="16" required/> <br>
	                        </div>
	                        <div class="droit">
	                            <label for="Titulaire">Titulaire de la carte</label> <br>
	                            <input class="inputText" type="text" name="Titulaire" id="Titulaire" maxlength="255" required/> <br>
	                        </div>
	                        <div class="droit">
	                        	<div>
		                            <label for="mois">Date d'expiration</label> <br>
		                            <div class="droit">
			                            <input class="inputText" type="number" name="mois" id="mois" min="1" max="12" required/> <br>
			                            <input class="inputText" type="number" name="annee" id="annee" min="24" max="99" required/> <br>
			                        </div>
		                        </div>
		                        <div>
		                            <label for="crypto">Cryptogramme</label> <br>
		                            <input class="inputText" type="number" name="crypto" id="crypto" min="100" max="999" required/> <br>
		                        </div>
	                        </div>

                            <input class="bouton" type="submit" name="connexion" value="Payer"/> <br>
						</form>
					</div>
				</div>
				<?php include('php/footer.html'); ?>
			</body>
		</html>
	<?php }
	else{header('Location: /');}
}
else{header('Location: /');}?>