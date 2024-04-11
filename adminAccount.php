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
	$User_tab = $bdd->prepare('SELECT IdAccount,Pseudo,Password FROM Account WHERE Pseudo=:user AND Password=:password AND IdAccount IN (SELECT IdAccount FROM Admin)');
	$User_tab->execute(array('user'=>$user, 'password'=>$password));
	if($User=$User_tab->fetch()){ ?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>Admin</title>
				<?php include('php/head.html');?>
				<link rel="stylesheet" type="text/css" href="css/admin.css" media="all" />
				<link rel="stylesheet" type="text/css" href="css/messagerie.css" media="all" />
				<link rel="stylesheet" type="text/css" href="css/profil.css" media="all" />
				<script type="text/javascript" src="js/messagerie.js"></script>
				<script type="text/javascript" src="js/admin.js"></script>
				<script type="text/javascript" src="js/profil.js"></script>
			</head>
			<body onload="loadProfil()">
				<?php include("php/header.php"); ?>
				<div class="contener">
					<h1>Bienvenue dans la partie Administrateur</h1>
					<div>
						<div id="contenerSignalement">
							<h3>Comptes signalés</h3>
							<div>
							<?php 
								$Report_tap = $bdd->query('SELECT * FROM ReportAccount ORDER BY IdAccount');
								while($Report=$Report_tap->fetch()){ 
									$AccountReport_tab = $bdd->prepare('SELECT Pseudo, ProfilPictureFile FROM Account WHERE IdAccount = :idaccount');
									$AccountReport_tab->execute(array('idaccount'=>$Report['IdAccount']));
									if($AccountReport=$AccountReport_tab->fetch()){
										?>
										<div>
											<?php echo $AccountReport['Pseudo']; ?>
										</div>
									<?php }
								}
							?>
							</div>
							<h3>Messages signalés</h3>
							<div id="MsgReported">
							<?php 
								$Report_tap = $bdd->query('SELECT * FROM ReportMsg ORDER BY IdMessage');
								while($Report=$Report_tap->fetch()){
									$MsgReport_tab = $bdd->prepare('SELECT DATE_FORMAT(DateSend, \'%d/%m/%Y %H:%i\') AS date, DATE_FORMAT(DateSend, \'%Y-%m-%d-%H-%i-%s\') AS dateformat, Content, IdSender, IdRecipient, IdMessage FROM Message WHERE IdMessage = :idmessage');
									$MsgReport_tab->execute(array('idmessage'=>$Report['IdMessage']));
									if($MsgReport=$MsgReport_tab->fetch()){

										$Sender_tab = $bdd->prepare('SELECT Pseudo, ProfilPictureFile FROM Account WHERE IdAccount=:idsender');
										$Sender_tab->execute(array('idsender'=>$MsgReport['IdSender']));
										$Sender = $Sender_tab->fetch();

										$Reporter_tab = $bdd->prepare('SELECT Pseudo, ProfilPictureFile FROM Account WHERE IdAccount=:idsender');
										$Reporter_tab->execute(array('idsender'=>$MsgReport['IdRecipient']));
										$Reporter = $Reporter_tab->fetch();
										?>
										<div class="MsgReported">
											<div onclick="loadknownProfil('<?php echo $MsgReport['IdRecipient'];?>','Messagerie','<?php echo $MsgReport['IdMessage'];?>')">
											<?php 
												$_GET['IdMessage'] = $MsgReport['IdMessage'];
												$_GET['IdSender'] = $MsgReport['IdSender'];
												$_GET['IdAccount'] = $MsgReport['IdSender'];
												$_GET['Content'] = $MsgReport['Content'];
												$_GET['dateformat'] = $MsgReport['dateformat'];
												$_GET['date'] = $MsgReport['date'];
												
												include('php/msg.php');
											?>
											</div>
											<div class="profilReport" id="Sender" onclick="loadknownProfil('<?php echo $MsgReport['IdSender'];?>','Account')">
												<img class="profilPicture" src="img/<?php echo $MsgReport['IdSender']."/".$Sender['ProfilPictureFile'];?>">
												<div class="pseudo"><?php echo $Sender['Pseudo']; ?></div>
											</div>
											<div id="ReporterContener">
												<div class="profilReport" id="Reporter" onclick="loadknownProfil('<?php echo $MsgReport['IdRecipient'];?>','Account')">
													<div class="pseudo"><?php echo $Reporter['Pseudo']; ?></div>
													<img class="profilPicture" src="img/<?php echo $MsgReport['IdRecipient']."/".$Reporter['ProfilPictureFile'];?>">
												</div>
											</div>
										</div>
									<?php }
								}
							?>
							</div>
						</div>
						<div class="reglage">
							<h2>Selectionner un compte à administrer.</h2>
							<select name="user" id="user" onchange="loadProfil()" required>
								<?php
								$User_tab = $bdd->query('SELECT IdAccount, Pseudo, FirstName, Name FROM Account ORDER BY IdAccount');
								while($User=$User_tab->fetch()){
									echo '<option value="'.$User['IdAccount'].'">'.$User['Pseudo'].' ('.$User['Name'].' '.$User['FirstName'].')</option>';
								}
								?>
							</select>
							<div class="selecteur">
								<input type="radio" name="type" class="radioCacher" 
											value="Account" 
											id="Account"
											onclick="loadProfil()" checked>
								<label class="type" for="Account">
									<div class="pseudo">Account</div>
								</label>
								<input type="radio" name="type" class="radioCacher" 
											value="Messagerie" 
											id="Messagerie"
											onclick="loadProfil()">
								<label class="type" for="Messagerie">
									<div class="pseudo">Messagerie</div>
								</label>
							</div>
							<div id="boutonSuppr">
								Supprimer Compte
							</div>
						</div>
						<div id="contenerEmulateur">
							<div id="emulateur">
							</div>
						</div>
					</div>
				<div>
			</body>
		</html>
	<?php }
	else{header('Location: /');}
}
else{header('Location: /');}?>

<?php include('php/footer.php'); ?>
