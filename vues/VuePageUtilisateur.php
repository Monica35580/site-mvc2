<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Site MVC</title>
	<link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
	<div id="page">
		<h3>Page d'accueil de l'utilisateur <?php echo $utilisateur->getPrenom() . " " . $utilisateur->getNom(); ?></h3>
		<p><a href="index.php?action=ChangerDeMdp&login=<?php echo $utilisateur->getLogin() ?>" class="bouton-menu">Modifier mon mot de passe</a></p>
		<p><a href="index.php?action=Connecter" class="bouton-menu">Retour à la page de connexion</a></p>
	</div>
</body>
</html>