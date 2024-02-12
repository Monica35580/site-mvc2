<?php
// fichier : modele/parametres.php
// Rôle : inclure les paramètres de l'application (hébergement en localhost)
// Dernière mise à jour : 3/7/2021 par dP

// paramètres de connexion -----------------------------------------------------------------------------------
global $PARAM_HOTE, $PARAM_PORT, $PARAM_BDD, $PARAM_USER, $PARAM_PWD;
$PARAM_HOTE = "localhost";  // si le sgbd est sur la même machine que le serveur php
$PARAM_PORT = "3306";       // le port utilisé par le serveur MySql
$PARAM_BDD = "bddmvc";		// nom de la base de données
$PARAM_USER = "bddmvc";		// nom de l'utilisateur
$PARAM_PWD = "cvmddb";		// son mot de passe

// adresse de l'émetteur lors d'un envoi de courriel
$ADR_MAIL_EMETTEUR = "delasalle.sio.crib@gmail.com";

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces après la balise de fin de script !!!!!!!!!!!!