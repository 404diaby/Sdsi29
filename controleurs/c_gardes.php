<?php
// ****************************************'
//  Le CASTEL-BTS SIO/ PROJET SDIS29       '
//  Programme: c_gardes.php                '
//  Objet    : gestion des gardes          '
//  Client   : Bts SIO2                    '
//  Version  : 1.0                         '
//  Date     : 11/10/2018 à 22h31          '
//  Auteur   : pascal-blain@wanadoo.fr     '
//*****************************************'
$action = $_REQUEST['action'];
switch($action) 
{
case 'voir':
	{//si on rend indispo une tranche il faut verifier si la garde vaut 1 et donc aller enlever  un nb de pompier a la garde et sur le nb est 1 il faur le supprimer 
		$formulaire ="frmGarde"; //???
		$champ = "ztLaDate";///????
		include("vues/v_entete.php");
		if(!isset($_REQUEST['zSemaine'])){$_REQUEST['zSemaine'] = date('W')+1;}
		$semaine = 43;//$_REQUEST['zSemaine']; probleme bouton prochaine semaine dans feuille garde
		if(!isset($_REQUEST['zAnnee'])){$_REQUEST['zAnnee'] = date('Y');}
		$annee 			= $_REQUEST['zAnnee'];
		$sem			= intval($semaine)-1;
		$premierJour 	= strtotime("+$sem weeks",mktime(0,0,0,1,1,$annee));
		if (date('w',$premierJour) != 1){$premierJour = strtotime("last monday",$premierJour);}
		$lesTranches	= $pdo->getParametre("tranche");	
		$lesTypesDispos	= $pdo->getParametre("dispo");
		$lesPompiers		= $pdo->getLesPompiers($_SESSION['cis']);
		//$lesDispos		= $pdo->getDisposHebdo("*", $semaine, $annee);
		foreach ($lesPompiers as $unPompier) {
			$lesDisposPompiers[$unPompier['pId']] = $pdo->getDisposHebdo($unPompier['pId'], $semaine, $annee);
		}

		include("vues/v_ficheGardes.php");
		break;
	}
//----------------------------------------- 
case 'majGarde':
	{
		
		
		$garde = $_REQUEST['ztGarde'];
		$date = $_REQUEST['ztDate'];
		$tranche = $_REQUEST['ztTranche'];
		$pompier = $_REQUEST['ztunPompier'];

		$pdo->majGarde( $date ,  $tranche , $garde , $pompier );
		


		header ('location: index.php?choixTraitement=gardes&action=voir&zSemaine='.$_REQUEST["zSemaine"].'&zAnnee='.$_REQUEST["zAnnee"]);
		break;
	}
//----------------------------------------- 
default :
	{
		echo 'erreur d\'aiguillage !'.$action;
		break;
	}
}
?>
