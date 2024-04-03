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
					<a class="msgTopLeft" href="profilPublic.php?user=<?php echo $Contact['Pseudo'];?>">
						<img class="profilPicture" src="img/<?php echo $reciver."/".$Contact['ProfilPictureFile'];?>">
						<h2 id="Reciver"><?php echo $Contact['Pseudo'];?></h2>
					</a>
					<div class="msgTopRight" onclick="showHide('spanTroisPoint')">
						<svg class="petitPoints" viewBox="0 0 100 100">
							<circle r="5" cx="50" cy="25" fill="#602320" />
							<circle r="5" cx="50" cy="50" fill="#602320" />
							<circle r="5" cx="50" cy="75" fill="#602320" />
						</svg>
					</div>
					<div id="spanTroisPoint">
						<div class="bouton">
							<a href="profilPublic.php?user=<?php echo $Contact['Pseudo'];?>">Consulter profil</a>
						</div>
						<div class="bouton red">
							<div>Bloquer</div>
						</div>
					</div>
				</div>
				<div class="msgBody">
					<div id="msgContener">
						<?php
						$msgNb = 1;
						$Msg_tab = $bdd->prepare('SELECT DATE_FORMAT(DateSend, \'%d/%m/%Y %H:%i\') AS date, DATE_FORMAT(DateSend, \'%Y-%m-%d-%H-%i-%s\') AS dateformat, Content, IdSender FROM Message WHERE ((IdSender = :idaccount1 AND IdRecipient = :idaccount2) OR (IdSender = :idaccount2 AND IdRecipient = :idaccount1)) ORDER BY DateSend');
						$Msg_tab->execute(array('idaccount1'=>$User['IdAccount'], 'idaccount2'=>$reciver));
						while($Msg=$Msg_tab->fetch()){
							?>
							<div id="<?php echo $msgNb; $msgNb++;?>" class="<?php if($Msg['IdSender'] == $User['IdAccount']){echo "sender";}else{echo "reciver";}?>">
								<div class="msg">
									<div class="content"><?php echo $Msg['Content'];?></div>
									<div class="hour"><?php 
										$date_liste=explode('-',date('Y-m-d-H-i-s'));
										$date_aliste=explode('-',$Msg['dateformat']);
										$date_=$date_liste['0']*31557600+$date_liste['1']*2629800+$date_liste['2']*86400+$date_liste['3']*3600+$date_liste['4']*60+$date_liste['5'];
										$date_a=$date_aliste['0']*31557600+$date_aliste['1']*2629800+$date_aliste['2']*86400+$date_aliste['3']*3600+$date_aliste['4']*60+$date_aliste['5'];
										$Date_=$date_-$date_a;
										if($Date_<3600){echo intdiv($Date_,60).' min';}
										elseif($Date_<86400){echo intdiv($Date_,3600).' h';}
										elseif($Date_<2629800){echo $Msg['date'];}
									?></div>
								</div>
							</div>
							<?php 
						}
						?>
					</div>
					<div class="msgWriter">
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
