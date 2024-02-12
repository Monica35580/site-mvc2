<?php
// fichier : index.php
// Rôle : analyser toutes les demandes (appels de page ou traitements de formulaires) et activer le contrôleur chargé de traiter l'action demandée
// Dernière mise à jour : 3/7/2021 par dP

// Ce fichier est appelé par tous les liens internes, et par la validation de tous les formulaires
// il est appelé avec un paramètre action qui peut prendre les valeurs suivantes :

//    index.php?action=Connecter              : pour afficher la page de connexion
//    index.php?action=ChangerDeMdp           : pour afficher la page de changement de mot de passe

// il faut être administrateur pour l'action suivante :
//    index.php?action=SupprimerUtilisateur   : pour afficher la page de suppression d'un utilisateur 

// inclusion des paramètres de l'application
//include_once ('modele/parametres.php');

session_start();		// permet d'utiliser des variables de session
 
// on vérifie le paramètre action de l'URL
if ( ! isset ($_GET['action']) == true)  $action = 'Connecter';  else   $action = $_GET['action'];

// lors d'une première connexion, on supprime la variable de session qui mémorise le niveau de connexion (0, 1, 2)
if ($action == '' || $action == 'Connecter') {
    unset ($_SESSION['niveauConnexion']);
}

// tests de la variable de session
if ( ! isset ($_SESSION['niveauConnexion']) == true)  $niveauConnexion = 0;  else  $niveauConnexion = $_SESSION['niveauConnexion'];

switch($action){
	case 'Connecter': {
		include_once ('controleurs/CtrlConnecter.php'); break;
	}
	case 'ChangerDeMdp': {
	    include_once ('controleurs/CtrlChangerDeMdp.php'); break;
	}
	case 'SupprimerUtilisateur': {
		include_once ('controleurs/CtrlSupprimerUtilisateur.php'); break;
	}
	case 'ConsulterListeUtilisateurs': {
		include_once ('PageConsulterListeUtilisateurs.php'); break;
	}
	default : {
		// toute autre tentative est automatiquement redirigée vers le contrôleur d'authentification
		include_once ('controleurs/CtrlConnecter.php'); break;
	}
}