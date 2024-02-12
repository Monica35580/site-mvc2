<?php
// fichier : controleurs/CtrlChangerDeMdp.php
// Rôle : traiter la demande de changement de mot de passe d'un utilisateur
// Dernière mise à jour : 3/7/2021 par dP

// on vérifie si le demandeur de cette action est bien authentifié
if ($niveauConnexion == 0) {
    // si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
    // dans ce cas, on provoque une redirection vers la page de connexion
    header ("Location: index.php?action=Connecter");
    exit;
}

// récupération du login transmis par l'url ($_GET)
if ( empty($_GET['login']))  $login = '';  else   $login = $_GET['login'];

// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
if ( empty($_POST ["btnEnvoyer"])) {
	$mdp = '';
	$nouveauMdp = '';
	$nouveauMdpConfirm = '';
	$message = '';
	include_once ('vues/VueChangerDeMdp.php');
	exit;		// pour ne pas continuer la suite de ce script
}

// récupération des données postées ($_POST)
if ( empty($_POST['txtMdp']))  $mdp = '';  else   $mdp = $_POST['txtMdp'];
if ( empty($_POST['txtNouveauMdp']))  $nouveauMdp = '';  else   $nouveauMdp = $_POST['txtNouveauMdp'];
if ( empty($_POST['txtConfirmationMdp']))  $nouveauMdpConfirm = '';  else   $nouveauMdpConfirm = $_POST['txtConfirmationMdp'];

// tester si les données demandées ont bien été reçues
if ($mdp == "" || $nouveauMdp == ""||$nouveauMdpConfirm =="") {
	// si les données sont incomplètes, réaffichage de la vue avec un message explicatif
	$message = 'Erreur : données incomplètes.';
    include_once ('vues/VueChangerDeMdp.php');
    exit;		// pour ne pas continuer la suite de ce script
}

// tester si l'ancien et le nouveau mot de passe sont identiques
if ($mdp == $nouveauMdp ) {
    // si les données sont idetiques, réaffichage de la vue avec un message explicatif
    $message = "Erreur : le nouveau et l'ancien sont identiques.";
    include_once ('vues/VueChangerDeMdp.php');
    exit;		// pour ne pas continuer la suite de ce script
}

// tester si l'ancien et le nouveau mot de passe sont identiques
if ($nouveauMdp != $nouveauMdpConfirm ) {
    // si les données sont idetiques, réaffichage de la vue avec un message explicatif
    $message = "Erreur : confirmation inexacte.";
    include_once ('vues/VueChangerDeMdp.php');
    exit;		// pour ne pas continuer la suite de ce script
}

// tester si la longueur du nouveau mot de passe est bien >= à 8
//$EXPRESSION = "#^(([0-9]{1,2}|1[1-9][0-9]|2[0-4][0-9]|25[0-5])\.){3}([0-9]{1,2}|1[1-9][0-9]|2[0-4][0-9]|25[0-5])$#";
// on retourne true si le numéro est bon, mais aussi si le numéro est vide :
//if ( preg_match ( $EXPRESSION , $nouveauMdp) == true || $nouveauMdp == "" ) return true; else return false;


if (strlen($nouveauMdp) < 8||preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/', $nouveauMdp) == false || $nouveauMdp == "" )  {
	// si le mot de passe a moins de 8 caractères, réaffichage de la vue avec un message explicatif
	$message = 'Erreur : force insuffisante du mot de passe.';
	include_once ('vues/VueChangerDeMdp.php');
	exit;		// pour ne pas continuer la suite de ce script
}

// connexion du serveur web à la base MySQL
include_once ('modele/DAO.class.php');
$dao = new DAO();
$utilisateur = $dao->getUnUtilisateur($login);

// tester si l'ancien mot de passe est correct
if ($utilisateur->getMdpSha1() != sha1($mdp)) {
	// si le mot de passe est incorrect, réaffichage de la vue avec un message explicatif
	$message = "Erreur : l'ancien mot de passe est incorrect.";
	include_once ('vues/VueChangerDeMdp.php');
	exit;		// pour ne pas continuer la suite de ce script
}

// ++++++ tous les contrôles sont positifs : on peut effectuer le traitement ++++++

// hashage des mots de passe
$mdpSha1 = sha1($mdp);
$nouveauMdpSha1 = sha1($nouveauMdp);

// changement du mot de passe dans la bdd
$dao->changerMdpUtilisateur($login, $mdpSha1, $nouveauMdpSha1);

// fermeture de la connexion à MySQL
unset($dao);

// chargement de la vue
$message = 'Le mot de passe a bien été modifié.';
include_once ('vues/VueChangerDeMdp.php');
?>