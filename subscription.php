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

if(isset($_SESSION['password']) AND isset($_SESSION['user'])){
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
			</head>
			<body>
				<?php include("php/header.php"); ?>
				<div id="centreur">
					<div id="contener">
						<h2>Choisi un abonnement</h2>
						<form method="post" action="subscriptionPayment.php">
							<div id="abonnements">
								<input type="radio" name="typeAbonnement" class="radioCache" value="1" id="radio1" checked>

								<label class="abonnement" for="radio1">
									<img class="picture" src="img/DragonNiv1.png<?php echo $idcontact.$Contact['ProfilPictureFile'];?>">
									<h3>1 mois</h3>
									<div>8.99 €</div>
									<div>soit 8.99 €/mois</div>
								</label>


								<input type="radio" name="typeAbonnement" class="radioCache" value="6" id="radio6">

								<label class="abonnement" for="radio6">
									<img class="picture" src="img/DragonNiv2.png<?php echo $idcontact.$Contact['ProfilPictureFile'];?>">
									<h3>6 mois</h3>
									<div>42,99 €</div>
									<div>soit 7.17 €/mois</div>
								</label>


								<input type="radio" name="typeAbonnement" class="radioCache" value="12" id="radio12">

								<label class="abonnement" for="radio12">
									<img class="picture" src="img/DragonNiv3.png<?php echo $idcontact.$Contact['ProfilPictureFile'];?>">
									<h3>12 mois</h3>
									<div>74.99 €</div>
									<div>soit 6.25 €/mois</div>
								</label>
							</div>
							<input type="submit" id="bouton" name="Ajouter" value="Payer">
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