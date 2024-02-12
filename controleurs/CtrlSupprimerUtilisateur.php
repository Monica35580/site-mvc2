<?php
// fichier : controleurs/CtrlSupprimerUtilisateur.php
// Rôle : traiter la demande de suppression d'un utilisateur
// Dernière mise à jour : 3/7/2021 par dP

// on vérifie si le demandeur de cette action est bien authentifié comme administrateur
if ($niveauConnexion != 2) {
    // si le demandeur n'est pas un administrateur, il s'agit d'une tentative d'accès frauduleux
    // dans ce cas, on provoque une redirection vers la page de connexion
    header ("Location: index.php?action=Connecter");
    exit;
}

// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
if ( empty($_POST ["btnEnvoyer"])) {
	$login = '';
	$message = '';
	include_once ('vues/VueSupprimerUtilisateur.php');
	exit;		// pour ne pas continuer la suite de ce script
}

// récupération des données postées
if ( empty($_POST['txtLogin']))  $login = '';  else   $login = $_POST['txtLogin'];

// tester si les données demandées ont bien été reçues
if ($login == "") {
	// si les données sont incomplètes, réaffichage de la vue avec un message explicatif
	$message = "Erreur : données incomplètes.";
    include_once ('vues/VueSupprimerUtilisateur.php');
    exit;		// pour ne pas continuer la suite de ce script
}

// connexion du serveur web à la base MySQL
include_once ('modele/DAO.class.php');
$dao = new DAO();

// récupération de l'objet Utilisateur correspondant au login
$unUtilisateur = $dao->getUnUtilisateur($login);

// tester si le login existe
if ($unUtilisateur == null) {
	// si le login n'existe pas, réaffichage de la vue avec un message explicatif
	$message = "Erreur : ce login n'existe pas.";
	include_once ('vues/VueSupprimerUtilisateur.php');
	unset($dao);
	exit;		// pour ne pas continuer la suite de ce script
}

// tester si le login est admin
if ($niveauConnexion == 2) {
    // si le login correspond à un administrateur, réaffichage de la vue avec un message explicatif
    $message = "Erreur : ce login correspond à un administrateur.";
    include_once ('vues/VueSupprimerUtilisateur.php');
    unset($dao);
    exit;		// pour ne pas continuer la suite de ce script
}

// suppression de l'utilisateur dans la bdd
$dao->supprimerUnUtilisateur($login);

// fermeture de la connexion à MySQL
unset($dao);

// chargement de la vue
$message = "L'utilisateur a bien été supprimé.";
include_once ('vues/VueSupprimerUtilisateur.php');
?>