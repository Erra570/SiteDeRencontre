<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}


if(isset($_SESSION['password']) AND isset($_SESSION['user'])){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$load = false;
	$target = 0;
	if(isset($_POST['target'])){
		$target = htmlspecialchars($_POST['target']);
		$Admin_tab = $bdd->prepare('SELECT IdAccount,Pseudo,Password FROM Account WHERE Pseudo=:user AND Password=:password AND IdAccount IN (SELECT IdAccount FROM Admin)');
		$Admin_tab->execute(array('user'=>$user, 'password'=>$password));
		$User_tab = $bdd->prepare('SELECT * FROM Account WHERE IdAccount=:idaccount');
		$User_tab->execute(array('idaccount'=>$target));
		$load = $User=$User_tab->fetch() AND $Admin=$Admin_tab->fetch();
	}
	else{
		$User_tab = $bdd->prepare('SELECT * FROM Account WHERE Pseudo=:user AND Password=:password');
		$User_tab->execute(array('user'=>$user, 'password'=>$password));
		$load = $User=$User_tab->fetch();
	}
	if($load){ ?>
		<body onload="loadChat('<?php if(isset($_POST['target'])){ echo $target;}?>'); instantane('<?php if(isset($_POST['target'])){ echo $target;}?>');">
			<div id="centreur">
				<div id="left">
					<div id="demandeDeDiscution">
						<h2>Demande</h2>
						<?php
						$AskerId_tab = $bdd->prepare('SELECT IdAsker FROM Contact WHERE IdAccount = :idaccount AND Approval is NULL AND 
							IdAsker not in (SELECT IdAccount FROM BlackList WHERE IdBlocked = :idaccount) AND 
							IdAsker not in (SELECT IdBlocked FROM BlackList WHERE IdAccount = :idaccount) AND 
							IdAccount not in (SELECT IdAccount FROM BlackList WHERE IdBlocked = :idaccount) AND 
							IdAccount not in (SELECT IdBlocked FROM BlackList WHERE IdAccount = :idaccount) ORDER BY IdAccount');
						$AskerId_tab->execute(array('idaccount'=>$User['IdAccount']));
						while($AskerId=$AskerId_tab->fetch()){
							$idAsker = $AskerId['IdAsker'];
							$Asker_tab = $bdd->prepare('SELECT Pseudo, ProfilPictureFile FROM Account WHERE IdAccount=:idcontact');
							$Asker_tab->execute(array('idcontact'=>$idAsker));
							if($Asker=$Asker_tab->fetch()){
							?>
								<div class="profil" id="<?php echo $Asker['Pseudo']; ?>">
									<a class="msgTopLeft" href="profilPublic.php?currentUser=<?php echo $Asker['Pseudo'];?>">
										<img class="profilPicture" src="img/<?php echo $idAsker."/".$Asker['ProfilPictureFile'];?>">
										<div><?php echo $Asker['Pseudo']; ?></div>
									</a>
									<svg class="croix vert" viewBox="0 0 100 100" onclick="accept(<?php echo "'".$Asker['Pseudo']."'"; if(isset($_POST['target'])){ echo ", '".$target."'";}?>)">
										<path class="line top" d="m 10 60 l 20 20" />
										<path class="line bottom" d="m 30 80 l 60 -60" />
									</svg>
									<svg class="croix rouge" viewBox="0 0 100 100" onclick="reject(<?php echo "'".$Asker['Pseudo']."'"; if(isset($_POST['target'])){ echo ", '".$target."'";}?>)">
										<path class="line top" d="m 10 10 l 80 80" />
										<path class="line bottom" d="m 10 90 l 80 -80 " />
									</svg>
								</div>
							<?php
							}
						}
						?>
					</div>
					<div id="discussionOuverte">
						<h2>Discussions</h2>
						<?php 
						$first = 0;
						$ContactId_tab = $bdd->prepare('SELECT IdAsker, IdAccount FROM Contact WHERE (IdAccount = :idaccount OR IdAsker = :idaccount) AND Approval=1 AND 
							IdAsker not in (SELECT IdAccount FROM BlackList WHERE IdBlocked = :idaccount) AND 
							IdAsker not in (SELECT IdBlocked FROM BlackList WHERE IdAccount = :idaccount) AND 
							IdAccount not in (SELECT IdAccount FROM BlackList WHERE IdBlocked = :idaccount) AND 
							IdAccount not in (SELECT IdBlocked FROM BlackList WHERE IdAccount = :idaccount) ORDER BY IdAccount');
						$ContactId_tab->execute(array('idaccount'=>$User['IdAccount']));
						while($ContactId=$ContactId_tab->fetch()){
							$idcontact = $ContactId['IdAccount'];
							if($ContactId['IdAsker'] != $User['IdAccount']){
								$idcontact = $ContactId['IdAsker'];
							}

							$Contact_tab = $bdd->prepare('SELECT Pseudo, ProfilPictureFile FROM Account WHERE IdAccount=:idcontact');
							$Contact_tab->execute(array('idcontact'=>$idcontact));
							if($Contact=$Contact_tab->fetch()){
							?>
								<input type="radio" name="reciver" class="radioCache" 
									value="<?php echo $Contact['Pseudo']; ?>" 
									id="<?php echo $Contact['Pseudo']; ?>" 
									<?php if($first == 0){echo "checked"; $first = 1;}?>
									onclick="loadChat('<?php if(isset($_POST['target'])){ echo $target;}?>')">

								<label class="profil" for="<?php echo $Contact['Pseudo'];?>" id="_<?php echo $Contact['Pseudo'];?>">
									<img class="profilPicture" src="img/<?php echo $idcontact."/".$Contact['ProfilPictureFile'];?>">
									<div class="pseudo"><?php echo $Contact['Pseudo']; ?></div>
								</label>
							<?php }
						}
						?>
					</div>
				</div>
				<div class="right" id="right">
					<p>Il n'y a personne ici</p>
				</div>
			</div>
		</body>
		<?php }
	else{
		header('Location: /');
	}
}
else{
	header('Location: /');
}?>
