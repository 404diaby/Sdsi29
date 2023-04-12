<?php
// ****************************************'
//  Le CASTEL-BTS SIO/ PROJET SDIS29       '
//  Programme: c_connexion.php             '
//  Objet    : authentification            '
//  Client   : Bts SIO2                    '
//  Version  : 2.0                         '
//  Date     : 11/10/2018 à 22h31          '
//  Auteur   : pascal.blain@ac-dijon.fr    '
//*****************************************'
if(!isset($_REQUEST['action'])){$_REQUEST['action'] = 'demandeConnexion';}
$action = $_REQUEST['action'];

switch($action){
	case 'demandeConnexion':{
		session_unset();
		unset($choix);
		$formulaire		="frmIdentification";
		$champ			="login";
		include("vues/v_entete.php");
		include("vues/v_connexion.php");
		break;	}
	case 'valideConnexion':{
		$login 			= $_REQUEST['login'];
		$mdp 			= md5($_REQUEST['mdp']);
		$utilisateur 	= $pdo->getInfosPompier($login,$mdp);
	 	if(!is_array( $utilisateur)){
			$formulaire		="frmIdentification";
			$champ			="login";
			include("vues/v_entete.php");
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");}
		else{
			$id 			= $utilisateur['id'];
			$nom 			= $utilisateur['nom'];
			$prenom 		= $utilisateur['prenom'];
			$a1				= $utilisateur['cNom'];
			$a2				= $utilisateur['cAdresse'];
			$a3				= "<small>(GT de ".$utilisateur['cGroupement'].")</small>";
			$a4				= $utilisateur['cTel'];			
			connecter($utilisateur['pCis'],$id,$nom,$prenom,$utilisateur['pStatut'], $a1, $a2, $a3, $a4);
			header ('location: index.php?choixTraitement=pompiers&action=voir');}
		break;}
	default :{
		$formulaire			="frmIdentification";
		$champ				="login";
		include("vues/v_entete.php");
		include("vues/v_connexion.php");
		break;}
}
?>