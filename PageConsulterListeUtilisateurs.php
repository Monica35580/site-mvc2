<?php
// on vérifie si le demandeur de cette action est bien un administrateur
if ($niveauConnexion != 2) {
	// si le demandeur n'est pas un administrateur, il s'agit d'une tentative d'accès frauduleux
	// dans ce cas, on provoque une redirection vers la page de connexion
	header ("Location: index.php?action=Connecter");
	exit;
}
// inclusion des paramètres de l'application et de la classe Utilisateur
include_once ('modele/parametres.php');
include_once ('modele/Utilisateur.class.php');
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
		<h3>Consulter la liste des utilisateurs</h3>
		
		<table class="tableau">				
			<thead>
			<tr>
				<th>Login</th>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Adresse mail</th>
			</tr>
			</thead>
			<?php
			// connexion à la base de données
			$cnx = new PDO ("mysql:host=" . $PARAM_HOTE . ";port=" . $PARAM_PORT . ";dbname=" . $PARAM_BDD, $PARAM_USER, $PARAM_PWD);
			
			// préparation de la requête de recherche
			$txt_req = "Select id, login, mdpSha1, nom, prenom, adrMail, numTel, niveau, dateCreation";
			$txt_req .= " from utilisateurs";
			$txt_req .= " where niveau = 1";
			$txt_req .= " order by login";
			
			$req = $cnx->prepare($txt_req);
			// extraction des données
			$req->execute();
			$uneLigne = $req->fetch(PDO::FETCH_OBJ);
			
			// construction d'une collection d'objets Utilisateur
			$lesUtilisateurs = array();
			// tant qu'une ligne est trouvée :
			while ($uneLigne) {
				// création d'un objet Utilisateur
				$unId = utf8_encode($uneLigne->id);
				$unLogin = utf8_encode($uneLigne->login);
				$unMdpSha1 = utf8_encode($uneLigne->mdpSha1);
				$unNom = utf8_encode($uneLigne->nom);
				$unPrenom = utf8_encode($uneLigne->prenom);
				$uneAdrMail = utf8_encode($uneLigne->adrMail);
				$unNumTel = utf8_encode($uneLigne->numTel);
				$unNiveau = utf8_encode($uneLigne->niveau);
				$uneDateCreation = utf8_encode($uneLigne->dateCreation);
				
				$unUtilisateur = new Utilisateur($unId, $unLogin, $unMdpSha1, $unNom, $unPrenom, $uneAdrMail, $unNumTel, $unNiveau, $uneDateCreation);
				
				// ajout de l'utilisateur à la collection
				$lesUtilisateurs[] = $unUtilisateur;
				// extrait la ligne suivante
				$uneLigne = $req->fetch(PDO::FETCH_OBJ);
			}
			// libère les ressources du jeu de données
			$req->closeCursor();
			
			foreach ($lesUtilisateurs as $unUtilisateur)
			{ ?>
				<tr>
					<td><?php echo $unUtilisateur->getLogin(); ?></td>
					<td><?php echo $unUtilisateur->getNom(); ?></td>
					<td><?php echo $unUtilisateur->getPrenom(); ?></td>
					<td><?php echo $unUtilisateur->getAdrMail(); ?></td>
				<?php
			} ?>
		</table>

		<p><a href="index.php?action=Connecter" class="bouton-menu">Retour à la page de connexion</a></p>
	</div>
</body>
</html>
