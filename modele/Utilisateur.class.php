<?php
// fichier : modele/Utilisateur.class.php
// Rôle : la classe Utilisateur représente les utilisateurs de l'application
// Dernière mise à jour : 3/7/2021 par dP

include_once ('Outils.class.php');

class Utilisateur
{
	// ------------------------------------------------------------------------------------------------------
	// ---------------------------------- Attributs privés de la classe -------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	private $id;                   // identifiant de l'utilisateur (numéro automatique dans la BDD)
	private $login;                // login de l'utilisateur
	private $mdpSha1;			   // mot de passe de l'utilisateur (hashé en SHA1)
	private $nom;                  // nom de l'utilisateur
	private $prenom;               // prénom de l'utilisateur
	private $adrMail;              // adresse mail de l'utilisateur
	private $numTel;               // numéro de téléphone de l'utilisateur
	private $niveau;               // niveau d'accès : 1 = utilisateur (pratiquant ou proche)    2 = administrateur
	private $dateCreation;         // date de création du compte
	
	// ------------------------------------------------------------------------------------------------------
	// ----------------------------------------- Constructeur -----------------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	public function __construct($unId, $unLogin, $unMdpSha1, $unNom, $unPrenom, $uneAdrMail, $unNumTel, $unNiveau, $uneDateCreation) {
		$this->id = $unId;
		$this->login = $unLogin;
		$this->mdpSha1 = $unMdpSha1;
		$this->nom = $unNom;
		$this->prenom = $unPrenom;
		$this->adrMail = $uneAdrMail;
		$this->numTel = Outils::corrigerTelephone($unNumTel);
		$this->niveau = $unNiveau;
		$this->dateCreation = $uneDateCreation;
	}	

	// ------------------------------------------------------------------------------------------------------
	// ---------------------------------------- Getters et Setters ------------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	public function getId()	{return $this->id;}
	public function setId($unId) {$this->id = $unId;}
	
	public function getLogin()	{return $this->login;}
	public function setLogin($unLogin) {$this->login = $unLogin;}
	
	public function getMdpSha1()	{return $this->mdpSha1;}
	public function setMdpSha1($unMdpSha1) {$this->mdpSha1 = $unMdpSha1;}
	
	public function getNom()	{return $this->nom;}
	public function setNom($unNom) {$this->nom = $unNom;}
	
	public function getPrenom()	{return $this->prenom;}
	public function setPrenom($unPrenom) {$this->prenom = $unPrenom;}
	
	public function getAdrMail()	{return $this->adrMail;}
	public function setAdrMail($uneAdrMail) {$this->adrMail = $uneAdrMail;}
	
	public function getNumTel()	{return $this->numTel;}
	public function setNumTel($unNumTel) {$this->numTel = Outils::corrigerTelephone($unNumTel);}

	public function getNiveau()	{return $this->niveau;}
	public function setNiveau($unNiveau) {$this->niveau = $unNiveau;}

	public function getDateCreation()	{return $this->dateCreation;}
	public function setDateCreation($uneDateCreation) {$this->dateCreation = $uneDateCreation;}
	
	// ------------------------------------------------------------------------------------------------------
	// -------------------------------------- Méthodes d'instances ------------------------------------------
	// ------------------------------------------------------------------------------------------------------

	public function toString() {
	    $msg  = 'id : ' . $this->id . '<br>';
	    $msg .= 'login : ' . $this->login . '<br>';
	    $msg .= 'mdpSha1 : ' . $this->mdpSha1 . '<br>';
	    $msg .= 'nom : ' . $this->nom . '<br>';
	    $msg .= 'prenom : ' . $this->prenom . '<br>';
	    $msg .= 'adrMail : ' . $this->adrMail . '<br>';
	    $msg .= 'numTel : ' . $this->numTel . '<br>';
	    $msg .= 'niveau : ' . $this->niveau . '<br>';
	    $msg .= 'dateCreation : ' . $this->dateCreation . '<br>';
	    return $msg;
	}
	
} // fin de la classe Utilisateur

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces après la balise de fin de script !!!!!!!!!!!!