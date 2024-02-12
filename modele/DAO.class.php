<?php
// fichier : modele/DAO.class.php   (DAO : Data Access Object)
// Rôle : fournit les méthodes d'accès à la bdd baseadefendre au moyen de l'objet PDO
// modifié le 3/7/2021 par dP

// liste des méthodes :

// __construct() : le constructeur crée la connexion $cnx à la base de données
// __destruct() : le destructeur ferme la connexion $cnx à la base de données
// getNiveauConnexion($login, $mdpSha1) : fournit le niveau (0, 1 ou 2) d'un utilisateur identifié par $login et $mdpSha1
// public function getUnUtilisateur($login) : fournit l'utilisateur identifié par $login (ou un objet nul si $login inexistant)
// public function changerMdpUtilisateur($id, $mdpSha1, $nouveauMdpSha1) : enregistre le nouveau mot de passe $nouveauMdpSha1 de l'utilisateur $id
// public function supprimerUnUtilisateur($login, $nom, $prenom) : supprime l'utilisateur $login dans la bdd

// inclusion des paramètres de l'application et de la classe Utilisateur
include_once ('parametres.php');
include_once ('Utilisateur.class.php');

// début de la classe DAO (Data Access Object)
class DAO
{
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------- Membres privés de la classe ---------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    private $cnx;				// la connexion à la base de données
    
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------- Constructeur et destructeur ---------------------------------------
    // ------------------------------------------------------------------------------------------------------
    public function __construct() {
        global $PARAM_HOTE, $PARAM_PORT, $PARAM_BDD, $PARAM_USER, $PARAM_PWD;
        try
        {	$this->cnx = new PDO ("mysql:host=" . $PARAM_HOTE . ";port=" . $PARAM_PORT . ";dbname=" . $PARAM_BDD,
            $PARAM_USER,
            $PARAM_PWD);
        return true;
        }
        catch (Exception $ex)
        {	echo ("Echec de la connexion a la base de donnees <br>");
        echo ("Erreur numero : " . $ex->getCode() . "<br />" . "Description : " . $ex->getMessage() . "<br>");
        echo ("PARAM_HOTE = " . $PARAM_HOTE);
        return false;
        }
    }
    
    public function __destruct() {
        // ferme la connexion à MySQL :
        unset($this->cnx);
    }
    
    // ------------------------------------------------------------------------------------------------------
    // -------------------------------------- Méthodes d'instances ------------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    // fournit le niveau (0, 1 ou 2) d'un utilisateur identifié par $login et $mdpSha1
    // cette fonction renvoie un entier :
    //     0 : authentification incorrecte
    //     1 : authentification correcte d'un utilisateur (pratiquant ou personne autorisée)
    //     2 : authentification correcte d'un administrateur
    public function getNiveauConnexion($login, $mdpSha1) {
        // transformation de la valeur de $login
        $login = htmlspecialchars($login, ENT_QUOTES);
        
        // préparation de la requête de recherche
        $txt_req = "Select niveau from utilisateurs";
        $txt_req .= " where login = :login";
        $txt_req .= " and mdpSha1 = :mdpSha1";
        $req = $this->cnx->prepare($txt_req);
        
        // liaison de la requête et de ses paramètres
        $req->bindValue("login", $login, PDO::PARAM_STR);
        $req->bindValue("mdpSha1", $mdpSha1, PDO::PARAM_STR);
        
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        
        // traitement de la réponse
        $niveau = 0;
        if ($uneLigne) {
            $niveau = $uneLigne->niveau;
        }
        // libère les ressources du jeu de données
        $req->closeCursor();
        // fourniture de la réponse
        return $niveau;
    }

    
    // fournit un objet Utilisateur à partir de son login
    // fournit la valeur null si le login n'existe pas
    public function getUnUtilisateur($login) {
        // préparation de la requête de recherche
        $txt_req = "Select id, login, mdpSha1, nom, prenom, adrMail, numTel, niveau, dateCreation";
        $txt_req .= " from utilisateurs";
        $txt_req .= " where login = :login";
        $req = $this->cnx->prepare($txt_req);
        
        // liaison de la requête et de ses paramètres
        $req->bindValue("login", $login, PDO::PARAM_STR);
        
        // extraction des données
        $req->execute();
        $uneLigne = $req->fetch(PDO::FETCH_OBJ);
        
        // libère les ressources du jeu de données
        $req->closeCursor();
        
        // traitement de la réponse
        if ( ! $uneLigne) {
            return null;
        }
        else {
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
            return $unUtilisateur;
        }
    }


    // enregistre le nouveau mot de passe $nouveauMdpSha1 de l'utilisateur $login après l'avoir hashé en SHA1
    // fournit true si la modification s'est bien effectuée, false sinon
    public function changerMdpUtilisateur($login, $mdpSha1, $nouveauMdpSha1) {
        // préparation de la requête de modification
        $txt_req = "Update utilisateurs";
        $txt_req .= " set mdpSha1 = :nouveauMdpSha1";
        $txt_req .= " where login = :login";
        $txt_req .= " and mdpSha1 = :mdpSha1";
        $req = $this->cnx->prepare($txt_req);
        
        // liaison de la requête et de ses paramètres
        $req->bindValue("nouveauMdpSha1", $nouveauMdpSha1, PDO::PARAM_STR);
        $req->bindValue("mdpSha1", $mdpSha1, PDO::PARAM_STR);
        $req->bindValue("login", $login, PDO::PARAM_STR);
        
        // exécution de la requête
        $ok = $req->execute();
        return $ok;
    }
    
    
    // supprime l'utilisateur $login dans la bdd
    // fournit true si l'effacement s'est bien effectué, false sinon
    public function supprimerUnUtilisateur($login) {
        // préparation de la requête de suppression
        $txt_req = "Delete from utilisateurs";
        $txt_req .= " where login = :login";
        $req = $this->cnx->prepare($txt_req);
        
        // liaison de la requête et de ses paramètres
        $req->bindValue("login", $login, PDO::PARAM_STR);
        
        // exécution de la requête
        $ok = $req->execute();
        return $ok;
    }

} // fin de la classe DAO

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces après la balise de fin de script !!!!!!!!!!!!