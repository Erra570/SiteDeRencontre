<?php 
session_start(); 

try{
	$bdd = new PDO('mysql:host=localhost;dbname=BddSiteDeRencontre;charset=utf8','User','fv_7qJ6j2_VY_T5',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}


if(isset($_SESSION['password']) AND isset($_SESSION['user']) AND isset($_POST['reciver'])){
	$user = htmlspecialchars($_SESSION['user']);
	$password = htmlspecialchars($_SESSION['password']);
	$reciverid = htmlspecialchars($_POST['reciver']);
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
	if($load){?>
		<?php 
		$Contact_tab = $bdd->prepare('SELECT Pseudo, ProfilPictureFile, IdAccount FROM Account WHERE Pseudo=:idcontact');
		$Contact_tab->execute(array('idcontact'=>$reciverid));
		if($Contact=$Contact_tab->fetch()){
			$reciver = $Contact['IdAccount'];
			$Liaison_tab = $bdd->prepare('SELECT IdAsker, IdAccount FROM Contact WHERE ((IdAccount = :idaccount1 AND IdAsker = :idaccount2) OR (IdAccount = :idaccount2 AND IdAsker = :idaccount1)) AND Approval=1');
			$Liaison_tab->execute(array('idaccount1'=>$User['IdAccount'], 'idaccount2'=>$reciver));
			if($Liaison=$Liaison_tab->fetch()){?>
				<div class="msgTop">
					<div class="msgTopLeft">
						<a class="msgTopLeft" href="profilPublic.php?user=<?php echo $Contact['Pseudo'];?>">
							<img class="profilPicture" src="img/<?php echo $reciver."/".$Contact['ProfilPictureFile'];?>">
							<h2 id="Reciver"><?php echo $Contact['Pseudo'];?></h2>
						</a>
						<?php 
							$Reported_tab = $bdd->prepare('SELECT * FROM ReportAccount WHERE IdReporter=:idaccount AND IdAccount= :idcontact');
							$Reported_tab->execute(array('idaccount'=>$User['IdAccount'], 'idcontact'=>$reciver));
							if($Reported=$Reported_tab->fetch()){
								echo '<div class="signalement">Cette utilisateur été signalé</div>';
							}
						?>
					</div>
					<div class="msgTopRight" onclick="showHide('spanTroisPoint')">
						<svg class="petitPoints" viewBox="0 0 100 100">
							<circle r="5" cx="50" cy="25" fill="#602320" />
							<circle r="5" cx="50" cy="50" fill="#602320" />
							<circle r="5" cx="50" cy="75" fill="#602320" />
						</svg>
					</div>
					<div id="spanTroisPoint">
						<a class="bouton" href="profilPublic.php?user=<?php echo $Contact['Pseudo'];?>">
							<div>Consulter profil</div>
						</a>
						<?php if(!isset($_POST['target'])){ ?>
							<div class="bouton red" onclick="reportAccount('<?php if(isset($_POST['target'])){ echo $target;}?>'); showHide('spanTroisPoint')">
								<div>Signaler</div>
							</div>
						<?php } ?>
						<div class="bouton red" onclick="block('<?php if(isset($_POST['target'])){ echo $target;}?>')">
							<div>Bloquer</div>
						</div>
					</div>
				</div>
				<div class="msgBody">
					<div id="msgContener">
						<?php
						$Msg_tab = $bdd->prepare('SELECT DATE_FORMAT(DateSend, \'%d/%m/%Y %H:%i\') AS date, DATE_FORMAT(DateSend, \'%Y-%m-%d-%H-%i-%s\') AS dateformat, Content, IdSender, IdMessage FROM Message WHERE ((IdSender = :idaccount1 AND IdRecipient = :idaccount2) OR (IdSender = :idaccount2 AND IdRecipient = :idaccount1)) ORDER BY DateSend');
						$Msg_tab->execute(array('idaccount1'=>$User['IdAccount'], 'idaccount2'=>$reciver));
						while($Msg=$Msg_tab->fetch()){
							$_GET['IdMessage'] = $Msg['IdMessage'];
							$_GET['IdSender'] = $Msg['IdSender'];
							$_GET['IdAccount'] = $User['IdAccount'];
							$_GET['Content'] = $Msg['Content'];
							$_GET['dateformat'] = $Msg['dateformat'];
							$_GET['date'] = $Msg['date'];
							
							include('msg.php');
						}
						?>
					</div>
					<div id="msgWriter">
						<input type="text" name="msgToSend" id="msgToSend">
					</div>
				</div>
			<?php }
			else{
				echo "4";
			}
		}
		else{
			echo "3";
		}
	}
	else{
		echo "2";
	}
}
else{
	echo "1";
}
?>
