<?php
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Site MVC</title>
	<link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
	<div id="page">
		<h3>Supprimer un utilisateur</h3>
		<form id="formConnexion" name="formConnexion" method="post" action="index.php?action=SupprimerUtilisateur" >
			<p>
				<label for="txtLogin">Login :</label>
				<input type="text" id="txtLogin" name="txtLogin" required value="<?php echo $login; ?>" />
			</p>
			<p><input type="submit" id="btnEnvoyer" name="btnEnvoyer" value="Envoyer" />
			<p><a href="index.php?action=Connecter" class="bouton-menu">Retour à la page de connexion</a></p>
			<p id="message-erreur"><?php echo $message; ?></p>
		</form>
	</div>
</body>
</html>
