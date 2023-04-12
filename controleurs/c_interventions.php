<?php
// ****************************************'
//  Le CASTEL-BTS SIO/ PROJET SDIS29       '
//  Programme: c_interventions.php         '
//  Objet    : gestion des interventions   '
//  Client   : Bts SIO2                    '
//  Version  : 1.0                         '
//  Date     : 11/10/2018 à 22h31          '
//  Auteur   : pascal-blain@wanadoo.fr     '
//*****************************************'
$action = $_REQUEST['action'];
switch($action) 
{
case 'voir': {
		include("vues/v_entete.php");
		













		break;}
//----------------------------------------- 
case 'majGarde': {
		$pdo->majGarde($_REQUEST["ztLaDate"], $_REQUEST["ztLaTranche"], $_REQUEST["ztExGarde"], $_REQUEST["ztPompier"]);
		header ('location: index.php?choixTraitement=gardes&action=voir&zSemaine='.$_REQUEST["zSemaine"].'&zAnnee='.$_REQUEST["zAnnee"]);
		break;}

//----------------------------------------- 
default : {
		echo 'erreur d\'aiguillage !'.$action;
		break;}
}
/* table equipe:
eCis  		smallint(6)
ePompier 	smallint(6)
eIntervention 	smallint(6) 

table intervention :
iCis  		smallint(6)
iId 		smallint(6)
iLieu 		varchar(50)
iDescription 	varchar(255)
iDate 		datetime 
iTranche 	tinyint(3) 	
iHeureDebut datetime 	
iHeureFin 	datetime	*/
?>
