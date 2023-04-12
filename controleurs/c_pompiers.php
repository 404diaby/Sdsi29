<?php
// ****************************************'
//  Le CASTEL-BTS SIO/ PROJET SDIS29       '
//  Programme: c_pompiers.php              '
//  Objet    : gestion des pompiers        '
//  Client   : Bts SIO2                    '
//  Version  : 2.0                         '
//  Date     : 11/10/2018 à 22h31          '
//  Auteur   : pascal.blain@ac-dijon.fr    '
//*****************************************'
$action = $_REQUEST['action'];
switch($action) {
case 'voir': {
	
		$formulaire		="choixP";
		$champ			="lstPompiers";	
		include("vues/v_entete.php");
		$lesLignes		=$pdo->getLesPompiers($_SESSION['cis']);
		$titre 			= 'Liste pompiers'; /* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/ 
		include("vues/v_choixPompier.php");
		$lesInfosPompier = $pdo->getInfosPompier("*",$choix);
		$lesTranches	= $pdo->getParametre("tranche");
	
		$lesGardes		= $pdo->getInfosGardes($choix);
		if(!isset($_REQUEST['zSemaine'])){$_REQUEST['zSemaine'] = date('W')+1;}
		$semaine 		= $_REQUEST['zSemaine'];
		if(!isset($_REQUEST['zAnnee'])){$_REQUEST['zAnnee'] = date('Y');}
		$annee 			= $_REQUEST['zAnnee'];
		$lesDispos		= $pdo->getDisposHebdo($choix, $semaine, $annee); 
		$sem			= intval($semaine)-1;
		$premierJour 	= strtotime("+$sem weeks",mktime(0,0,0,1,1,$annee));
		if (date('w',$premierJour) != 1){$premierJour = strtotime("last monday",$premierJour);}
		$lesTypesDispos	= $pdo->getParametre("dispo");
		$leCentre= $lesInfosPompier['cGroupement'];
		$lesInfosCasernes = $pdo->getLesCasernes($leCentre);
		$lesTypes = $pdo->getParametre('typePer');
		$lesGrades = $pdo->getParametre('grade');
		$lesStatuts = $pdo->getParametre('statAgt');
		include("vues/v_fichePompier.php");
		break;}
//----------------------------------------- FORMULAIRE DE SAISIE
case 'ajouter':
case 'modifier':
case 'supprimer': { 
		$formulaire		="frmA";
		$champ			="ztNom";	
		include("vues/v_entete.php");
		$choix			= $_REQUEST['lstPompiers'];
		$lesInfosPompier	= $pdo->getInfosPompier("*",$choix);
		//$lesTypes 		= 		
		//$lesGrades 		= 
		//$lesStatuts		= 
		include("vues/v_unPompier.php");
		break;}
//----------------------------------------- VALIDATION	
case 'validerAjouter':
case 'validerModifier':	
case 'validerSupprimer': {
		$valeur	= $_REQUEST['agent'];		
		if ($_REQUEST['zOk']=="OK") 
		{
			if ($action==="validerSupprimer") {$pdo->supprimePompier($valeur);}
			else
				{
				$nom		= addslashes ($_REQUEST['ztNom']);
				$prenom		= addslashes ($_REQUEST['ztPrenom']);
				$statut		= $_REQUEST['ldrStatut'];
				$mail		= $_REQUEST['ztMail'];
				$login		= $_REQUEST['ztLogin'];
				$mdp		= md5($_REQUEST['ztMdp']);	if($_REQUEST['brMdp']==0 AND $action==="validerModifier") {$mdp="*";}
				$territoire	= $_REQUEST['ldrTerritoire'];
				$adresse	= addslashes ($_REQUEST['ztAdresse']);
				if (strlen($_REQUEST['ztCP'])>1)				{$cp	= $_REQUEST['ztCP'];} else {$cp = "Null";}
				$ville			= addslashes ($_REQUEST['ztVille']);
				if (strlen($_REQUEST['ztTel'])>1) 			{$tel	= str_replace(" ", "", $_REQUEST['ztTel']); $tel=str_replace(".", "", $tel);	$tel=str_replace("/", "", $tel);} else {$tel="Null";}
				$commentaire	= addslashes ($_REQUEST['ztObs']);
				if ($action==="validerAjouter") 
					{$pdo->ajoutPompier($valeur,$nom,$prenom,$statut,$mail,$login,$mdp,$territoire,$adresse,$cp,$ville,$tel,$commentaire);
					$sujet 	= "nouveau compte";
					$msg = "Bonjour ".$prenom." ".$nom.", \r\nLe Castel vient de créer un compte pour vous  ...\r\n";
					}
				else 
					{$pdo->majPompier($valeur,$nom,$prenom,$statut,$mail,$login,$mdp,$territoire,$adresse,$cp,$ville,$tel,$commentaire);
					$sujet 	= "nouveau mot de passe";
					$msg = "Bonjour ".$prenom." ".$nom.", \r\nLe Castel vient de modifier votre mot de passe  ...\r\n";
					}		
				$entete	= "From: Pascal Blain <pascal-blain@wanadoo.fr>\r\n";
				$entete	.= "Mime-Version: 1.0\r\n";
				$entete	.= "Content-type: text/html; charset=utf-8\r\n";
				$entete	.= "\r\n";
				$msg .= "Statut : ".$statut."\r\n";
				$msg .= "Identifiant : ".$login."\r\n";
				$msg .= "Mot de passe : ".$_REQUEST['ztMdp']."\r\n";
				//$pdo->envoyerMail($mail, $sujet, $msg, $entete);
				}
		}
		header ('location: index.php?choixTraitement=pompiers&action=voir&lstPompiers='.$valeur);
		break;}
//----------------------------------------- 
case 'majActivite': {
	
		$pdo->majActivite($_REQUEST["ztLaDate"], $_REQUEST["ztLaTranche"], $_REQUEST["ztExDispo"],$_REQUEST["brDispo"] );
		header ('location: index.php?choixTraitement=pompiers&action=voir&zSemaine='.$_REQUEST["zSemaine"].'&zAnnee='.$_REQUEST["zAnnee"]);
		break;}
		
//----------------------------------------- 
default : {
		echo 'erreur d\'aiguillage !'.$action;
		break;}
}
?>
