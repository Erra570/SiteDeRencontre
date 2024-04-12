<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}

if(isset($_SESSION['password']) AND isset($_SESSION['user']) AND isset($_POST['pseudo']) AND 
	isset($_POST['name']) AND isset($_POST['firstName']) AND isset($_POST['mail']) AND 
	isset($_POST['country']) AND isset($_POST['city']) AND isset($_POST['sexe']) AND isset($_POST['dateOfBirth'])){

	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);

	$load = false;
	if(isset($_POST['target'])){
		$target = htmlspecialchars($_POST['target']);
		$Admin_tab = $bdd->prepare('SELECT IdAccount,Pseudo,Password FROM Account WHERE Pseudo=:user AND Password=:password AND IdAccount IN (SELECT IdAccount FROM Admin)');
		$Admin_tab->execute(array('user'=>$user, 'password'=>$password));
		$User_tab = $bdd->prepare('SELECT IdAccount FROM Account WHERE IdAccount=:idaccount');
		$User_tab->execute(array('idaccount'=>$target));
		$load = $User=$User_tab->fetch() AND $Admin=$Admin_tab->fetch();
	}
	else{
		$User_tab = $bdd->prepare('SELECT IdAccount FROM Account WHERE Pseudo=:user AND Password=:password');
		$User_tab->execute(array('user'=>$user, 'password'=>$password));
		$load = $User=$User_tab->fetch();
	}
	if($load){
		$req = 'UPDATE Account SET 
			Pseudo = :pseudo,
			Name = :name,
			FirstName = :firstName,
			Mail = :mail,
			Country = :country,
			City = :city,
			Sexe = :sexe,
			DateOfBirth = :dateOfBirth';

		$pseudo = htmlspecialchars($_POST['pseudo']);
		$name = htmlspecialchars($_POST['name']);
		$firstName = htmlspecialchars($_POST['firstName']);
		$mail = htmlspecialchars($_POST['mail']);

		$country = htmlspecialchars($_POST['country']);
		$city = htmlspecialchars($_POST['city']);

		if(isset($_POST['street'])){
			$street = htmlspecialchars($_POST['street']);
			$req = $req.", Street = '".$street."'";
		}

		if(isset($_POST['adressNumber']) AND htmlspecialchars($_POST['adressNumber']) != ''){
			$adressNumber = htmlspecialchars($_POST['adressNumber']);
			$req = $req.', AdressNumber = '.$adressNumber;
		}
		else{
			$req = $req.', adressNumber = NULL';
		}

		if(isset($_POST['welcomeMessage'])){
			$welcomeMessage = htmlspecialchars($_POST['welcomeMessage']);
			$req = $req.", WelcomeMessage = '".$welcomeMessage."'";
		}

		$sexe = htmlspecialchars($_POST['sexe']);
		$dateOfBirth = htmlspecialchars($_POST['dateOfBirth']);

		if(isset($_POST['species'])){
			$species = htmlspecialchars($_POST['species']);
			$req = $req.", Species = '".$species."'";
		}

		if(isset($_POST['love']) AND htmlspecialchars($_POST['love']) != ''){
			$love = htmlspecialchars($_POST['love']);
			$req = $req.", LoveSituation = '".$love."'";
		}

		if(isset($_POST['humanoidGauge']) AND htmlspecialchars($_POST['humanoidGauge']) != ''){
			$humanoidGauge = htmlspecialchars($_POST['humanoidGauge']);
			$req = $req.', HumanoidGauge = '.$humanoidGauge;
		}
		else{
			$req = $req.', HumanoidGauge = NULL';
		}

		if(isset($_POST['size']) AND htmlspecialchars($_POST['size']) != ''){
			$size = htmlspecialchars($_POST['size']);
			$req = $req.', Size = '.$size;
		}
		else{
			$req = $req.', Size = NULL';
		}

		if(isset($_POST['weight']) AND htmlspecialchars($_POST['weight']) != ''){
			$weight = htmlspecialchars($_POST['weight']);
			$req = $req.', Weight = '.$weight;
		}
		else{
			$req = $req.', Weight = NULL';
		}

		if(isset($_POST['eyeColor'])){
			$eyeColor = htmlspecialchars($_POST['eyeColor']);
			$req = $req.", EyeColor = '".$eyeColor."'";
		}

		$req = $req.' WHERE IdAccount = :idaccount';

		$request = $bdd->prepare($req);
		$request->execute(array('idaccount'=>$User['IdAccount'], 
			'pseudo' => $pseudo,
			'name' => $name,
			'firstName' => $firstName,
			'mail' => $mail,
			'country' => $country,
			'city' => $city,
			'sexe' => $sexe,
			'dateOfBirth' => $dateOfBirth));
	}
}
?>