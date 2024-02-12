<?php
// fichier : controleurs/CtrlConnecter.php
// Rôle : traiter la demande de connexion d'un utilisateur
// Dernière mise à jour : 3/7/2021 par dP

// Ce contrôleur vérifie l'authentification de l'utilisateur
// si l'authentification correspond à un simple utilisateur, on affiche la page utilisateur (vue VuePageUtilisateur.php)
// si l'authentification correspond à un administrateur, on affiche la page administrateur (vue VuePageAdministrateur.php)
// si l'authentification est incorrecte, on affiche la page d'erreur de connexion (vue VueErreurConnexion.php)

// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
if ( empty($_POST ["btnEnvoyer"])) {
    $login = '';
    $mdp = '';
    $niveauConnexion = 0;
    $message = '';
    include_once ('vues/VueConnecter.php');
    exit;		// pour ne pas continuer la suite de ce script
}

// récupération des données postées
if ( empty($_POST['txtLogin']))  $login = '';  else   $login = $_POST['txtLogin'];
if ( empty($_POST['txtMdp']))    $mdp = '';    else   $mdp = $_POST['txtMdp'];

// tester si les données demandées ont bien été reçues
if ($login == "" || $mdp == "") {
	// si les données sont incomplètes, réaffichage de la vue avec un message explicatif
	$message = 'Erreur : données incomplètes.';
	$niveauConnexion = 0;
    include_once ('vues/VueConnecter.php'); 
    exit;		// pour ne pas continuer la suite de ce script
}

// ++++++ tous les contrôles sont positifs : on peut effectuer le traitement ++++++

// connexion du serveur web à la base MySQL
include_once ('modele/DAO.class.php');
$dao = new DAO();

// recherche du niveau de l'utilisateur
$mdpSha1 = sha1($mdp);
$niveauConnexion = $dao->getNiveauConnexion($login, $mdpSha1);

// mémorisation du niveau de connexion dans une variable de session
$_SESSION['niveauConnexion'] = $niveauConnexion;

// si l'utilisateur existe, on le mémorise dans un objet qui sera utilisé par la vue VuePageUtilisateur.php
if ($niveauConnexion != 0) {
    $utilisateur = $dao->getUnUtilisateur($login);
}

// fermeture de la connexion à MySQL
unset($dao);		

// chargement de la vue en fonction du niveau de l'utilisateur
switch($niveauConnexion){
    case 1: {
        include_once ('vues/VuePageUtilisateur.php'); break;
    }
    case 2: {
        include_once ('vues/VuePageAdministrateur.php'); break;
    }
    default : {
        // toute autre tentative est automatiquement redirigée vers le formulaire d'authentification
    	$message = 'Erreur : authentification incorrecte.';
        include_once ('vues/VueConnecter.php'); break;
    }
}
?>