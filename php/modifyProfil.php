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
	isset($_POST['country']) AND isset($_POST['city']) AND isset($_POST['street']) AND 
	isset($_POST['adressNumber']) AND isset($_POST['sexe']) AND isset($_POST['dateOfBirth']) AND 
	isset($_POST['species']) AND isset($_POST['humanoidGauge']) AND isset($_POST['love']) AND isset($_POST['size']) AND 
	isset($_POST['weight']) AND isset($_POST['eyeColor'])){

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
		$pseudo = htmlspecialchars($_POST['pseudo']);
		$name = htmlspecialchars($_POST['name']);
		$firstName = htmlspecialchars($_POST['firstName']);
		$mail = htmlspecialchars($_POST['mail']);

		$country = htmlspecialchars($_POST['country']);
		$city = htmlspecialchars($_POST['city']);
		$street = htmlspecialchars($_POST['street']);
		$adressNumber = htmlspecialchars($_POST['adressNumber']);
		if($adressNumber == ""){
			$adressNumber = null;
		}

		$sexe = htmlspecialchars($_POST['sexe']);
		$dateOfBirth = htmlspecialchars($_POST['dateOfBirth']);
		$species = htmlspecialchars($_POST['species']);
		$love = htmlspecialchars($_POST['love']);
		$humanoidGauge = htmlspecialchars($_POST['humanoidGauge']);
		if($humanoidGauge == ""){
			$humanoidGauge = null;
		}
		$size = htmlspecialchars($_POST['size']);
		if($size == ""){
			$size = null;
		}
		$weight = htmlspecialchars($_POST['weight']);
		if($weight == ""){
			$weight = null;
		}
		$eyeColor = htmlspecialchars($_POST['eyeColor']);

		$request = $bdd->prepare('UPDATE Account SET 
			Pseudo = :pseudo,
			Name = :name,
			FirstName = :firstName,
			Mail = :mail,
			Country = :country,
			City = :city,
			Street = :street,
			AdressNumber = :adressNumber,
			Sexe = :sexe,
			DateOfBirth = :dateOfBirth,
			Species = :species,
			HumanoidGauge = :humanoidGauge,
			LoveSituation = :love,
			Size = :size,
			Weight = :weight,
			EyeColor = :eyeColor
			WHERE IdAccount = :idaccount');
		$request->execute(array('idaccount'=>$User['IdAccount'], 
			'pseudo' => $pseudo,
			'name' => $name,
			'firstName' => $firstName,
			'mail' => $mail,
			'country' => $country,
			'city' => $city,
			'street' => $street,
			'adressNumber' => $adressNumber,
			'sexe' => $sexe,
			'dateOfBirth' => $dateOfBirth,
			'species' => $species,
			'humanoidGauge' => $humanoidGauge,
			'love' => $love,
			'size' => $size,
			'weight' => $weight,
			'eyeColor' => $eyeColor));
	}
}
?>