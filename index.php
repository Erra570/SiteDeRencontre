<?php ?>
<!DOCTYPE html>
<html>
	<head>
		<script src="js/index.js"></script>
		<link rel="stylesheet" type="text/css" href="css/index.css" media="all" />
		<?php include('php/head.html');?>
	</head>
	<body>

		<?php include('php/header.php');?>
		
		<div class="milieu">
			<button class="bouton" onclick="window.location.href='inscription.php'">Créer un compte</button>
            <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous</a></p>
        </div>
		<div class="infos">
            <h1>Meestic</h1>
            <h3>Le site de rencontre pour trouver un amour hors du commun</h3>
        </div>
		<div class="text1">
			<div class ="image1"><img src="img/livre.png", width = 80%></div>
			<p>Abonnez-vous pour entamer une discussion avec qui vous voulez, où vous voulez, et ce que vous voulez !</p>
		</div>
		<div class="text2">
			<div class ="image2"><img src="img/coeur.png", width = 80%></div>
			<p>Connectez-vous afin de rencontrer l'âme-soeur, que vous soyez un elfe, un nain ou un orc.</p>
		</div>
		<div class="text3">
			<div class ="image3"><img src="img/oiseau.png", width = 80%></div>
			<p>Recherchez les profils qui VOUS correspondent, aussi improbables puissent-ils être.</p>
		</div>

		<?php include('php/footer.php'); ?>
		
	</body>
</html>