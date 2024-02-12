<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Site MVC</title>
	<link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
	<div id="page">
		<h3>Modifier mon mot de passe</h3>
		<form id="formModificationMdp" name="formModificationMdp" method="post" action="index.php?action=ChangerDeMdp&login=<?php echo $login?>" >
			<p>
				<label for="txtMdp">Ancien mot de passe :</label>
				<input type="password" id="txtMdp" name="txtMdp" required value="<?php echo $mdp; ?>" />
			</p>
			<p>
				<label for="txtNouveauMdp">Nouveau mot de passe :</label>
				<input type="password" id="txtNouveauMdp" name="txtNouveauMdp" required value="<?php echo $nouveauMdp; ?>" />
			</p>
			
			<p>
				<label for="txtNouveauMdp">Confirmation :</label>
				<input type="password" id="txtConfirmationMdp" name="txtConfirmationMdp" required value="<?php echo $nouveauMdpConfirm; ?>" />
			</p>
			<p><input type="submit" id="btnEnvoyer" name="btnEnvoyer" value="Envoyer" />
			<p><a href="index.php?action=Connecter" class="bouton-menu">Retour à la page de connexion</a></p>
			<p id="message-erreur"><?php echo $message; ?></p>
		</form>
	</div>
</body>
</html>