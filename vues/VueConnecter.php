<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Site MVC</title>
	<link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
	<div id="page">
		<h3>Se connecter</h3>
		<form id="formConnexion" name="formConnexion" method="post" action="index.php?action=Connecter" >
			<p>
				<label for="txtLogin">Login :</label>
				<input type="text" id="txtLogin" name="txtLogin" pattern="^[a-zA-Z0-9]+$" required value="<?php echo $login; ?>" />
			</p>
			<p>
				<label for="txtMdp">Mot de passe :</label>
				<input type="password" id="txtMdp" name="txtMdp" required value="<?php echo $mdp; ?>" />
			</p>
			<p><input type="submit" id="btnEnvoyer" name="btnEnvoyer" value="Envoyer" />
			<p id="message-erreur"><?php echo $message; ?></p>
		</form>
	</div>
</body>
</html>