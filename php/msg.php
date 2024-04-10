<?php 

if(isset($_GET['IdMessage']) AND isset($_GET['IdSender']) AND isset($_GET['IdAccount']) AND isset($_GET['Content']) AND isset($_GET['dateformat']) AND isset($_GET['date'])){ ?>

	<div id="<?php echo $_GET['IdMessage'];?>" class="<?php if($_GET['IdSender'] == $_GET['IdAccount']){echo "sender";}else{echo "reciver";}?>">
		<div class="msg">
			<div class="content"><?php echo $_GET['Content'];?></div>
			<svg class="petitPointsHorizontaux" viewBox="0 0 100 100" onclick="showHide('span<?php echo $_GET['IdMessage'];?>')">
				<circle r="5" cx="25" cy="50" fill="#602320" />
				<circle r="5" cx="50" cy="50" fill="#602320" />
				<circle r="5" cx="75" cy="50" fill="#602320" />
			</svg>
			<div class="span" id="span<?php echo $_GET['IdMessage'];?>">
				<?php if($_GET['IdSender'] == $_GET['IdAccount'] || isset($_POST['target'])){?>
					<div class="bouton" onclick="rmMsg(<?php echo $_GET['IdMessage'];?><?php if(isset($_POST['target'])){ echo ','.$target;}?>)">
						<div>Supprimer</div>
					</div>
				<?php } 
				else{ ?>
					<div class="bouton red" onclick="reportMsg('<?php echo $_GET['IdMessage'];?><?php if(isset($_POST['target'])){ echo ','.$target;}?>'); showHide('span<?php echo $_GET['IdMessage'];?>')">
						<div>Signaler</div>
					</div>
				<?php } ?>
			</div>
			<div class="hour"><?php 
				$date_liste=explode('-',date('Y-m-d-H-i-s'));
				$date_aliste=explode('-',$_GET['dateformat']);
				$date_=$date_liste['0']*31557600+$date_liste['1']*2629800+$date_liste['2']*86400+$date_liste['3']*3600+$date_liste['4']*60+$date_liste['5'];
				$date_a=$date_aliste['0']*31557600+$date_aliste['1']*2629800+$date_aliste['2']*86400+$date_aliste['3']*3600+$date_aliste['4']*60+$date_aliste['5'];
				$Date_=$date_-$date_a;
				if($Date_<3600){echo intdiv($Date_,60).' min';}
				elseif($Date_<86400){echo intdiv($Date_,3600).' h';}
				elseif($Date_<2629800){echo $_GET['date'];}
			?></div>
		</div>
	</div>
<?php
}
else{
	echo "if";
}
?>