<?php
/** 
 * @author 	: Pascal BLAIN, lycee le Castel à Dijon
 * @version : 1.2018-10-11
 * Classe d'acces aux donnees. Utilise les services de la classe PDO pour l'application
 * Les attributs sont tous statiques, les 4 premiers pour la connexion
 * $monPdo est de type PDO - $monPdoBD contient l'unique instance de la classe
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoBD
{   		
	private static $serveur='mysql:host=localhost';
	private static $bdd='dbname=sdis';   		
	private static $user='sio';    		
	private static $mdp='sio';	
	private static $monPdo;
	private static $monPdoBD=null;
			
	private function __construct()
	{
		PdoBD::$monPdo = new PDO(PdoBD::$serveur.';'.PdoBD::$bdd, PdoBD::$user, PdoBD::$mdp); 
		PdoBD::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct()
	{
		PdoBD::$monPdo = null;
	}

	/**
	 * Fonction statique qui cree l'unique instance de la classe PdoBD
	 * Appel : $instancePdoBD = PdoBD::getPdoBD();
	 */
	public  static function getPdoBD()
	{
		if(PdoBD::$monPdoBD==null)	{PdoBD::$monPdoBD= new PdoBD();}
		return PdoBD::$monPdoBD;  
	}

	/**
	 * Retourne les informations d'un centre de coordination
	 */
	public function getLesCasernes($leCentre)
	{		
		$req = "SELECT cId, cNom, cAdresse, cTel, cGroupement
					FROM caserne
					WHERE cGroupement='".$leCentre."'
					ORDER BY cNom;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des casernes ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	/**
	 * Retourne les informations des pompiers
	*/
	public function getLesPompiers($cis)
	{		
		$req = "SELECT pCis, pId, pNom, pPrenom, pStatut,pBip
					FROM pompier
					WHERE pCis=".$cis."
					ORDER BY pNom;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des pompiers ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	/**
	 * Retourne les informations d'un pompier sous la forme d'un tableau associatif
	*/
	public function getInfosPompier($login,$mdp)
	{
		$req = "SELECT pCis, pId as id, pNom as nom, pPrenom as prenom, pStatut, pMail, pLogin, pMdp, 
				pompier.pType, pGrade, pAdresse, pCp, pVille, pBip, pCommentaire, cNom, cAdresse, cGroupement, cTel,
				g.pLibelle as wGrade,  s.pLibelle as wStatut, t.pLibelle as wType
				FROM caserne INNER JOIN pompier 
				INNER JOIN parametre g ON (g.pType='grade' AND g.pIndice=pGrade)
					INNER JOIN parametre s ON (s.pType='statAgt' AND s.pIndice=pStatut)
					INNER JOIN parametre t ON (t.pType='typePer' AND t.pIndice=pompier.pType)
				
				
				";
		if ($login==="*") 
		{$req.=" WHERE pCis=".$_SESSION['cis']." AND pId=$mdp";}
		else 
		{$req.=" WHERE pLogin='$login' 
				 AND pMdp='$mdp'";}
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des informations d'un pompier...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetch();
		return $ligne;
	}
	
/**
 * Met à jour l'activité d'un pompier sur une tranche 
*/
	public function majActivite($jour, $tranche, $ancienneDispo, $nouvelleDispo)
	{	$cis = $_SESSION['cis'];
		$pompier = $_SESSION['idUtilisateur'];
		//update
		if ($ancienneDispo!=0 && $nouvelleDispo!=0)
		{$req = " UPDATE activite SET aDisponibilite = $nouvelleDispo WHERE aCis=$cis AND aPompier=$pompier AND aDateGarde='$jour' AND aTranche=$tranche;"; 
		}//insert
		elseif ($ancienneDispo==0 && $nouvelleDispo!=0)
		{$req = " INSERT INTO activite (aCis, aPompier, aDateGarde, aTranche, aDisponibilite , aGarde) VALUES ($cis , $pompier , '$jour' , $tranche , $nouvelleDispo, 0);";
		}
		else//delete
		{$req = " DELETE FROM activite
				WHERE aCis=$cis AND aPompier=$pompier AND aDateGarde='$jour' AND aTranche=$tranche;";
		}
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'activité dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

/**
 * Met à jour la garde d'un pompier sur une tranche 
*/
	public function majGarde($jour, $tranche, $garde, $pompier)
	{	$cis = $_SESSION['cis'];
		$uneGarde = $this->getGarde($jour, $tranche);
	
		if( $garde == 0 ){
			$nouvelleGarde = 1;
			if($uneGarde){
				//update
				$nbPompiers = $uneGarde['gNbPompiers']+1;
				$requete = "UPDATE garde SET  gNbPompiers = $nbPompiers WHERE gCis = $cis AND gDate = '$jour' AND gTranche = $tranche;";
			}else{
				//insert
				$nbPompiers = 1;
				$requete = "INSERT INTO garde ( gCis , gDate , gTranche, gNbPompiers) VALUES ($cis , '$jour',$tranche,$nbPompiers);";
			}
			//requete activite
			$req="UPDATE activite SET aGarde = $nouvelleGarde WHERE aCis = $cis AND aPompier = $pompier AND aDateGarde = '$jour'
				AND aTranche = $tranche;";
			$rs = PdoBD::$monPdo->exec($req);
			if ($rs === false) {
				afficherErreurSQL("Probleme table activite " , $req, PdoBD::$monPdo->errorInfo());
			}

		}
		
		if($garde == 1){
			
			$nouvelleGarde = 0;
				//requete activite
			$req="UPDATE activite SET aGarde = $nouvelleGarde WHERE aCis = $cis AND aPompier = $pompier AND aDateGarde = '$jour'
				AND aTranche = $tranche;";
			$rs = PdoBD::$monPdo->exec($req);
			if ($rs === false) {
				afficherErreurSQL("Probleme table activite " , $req, PdoBD::$monPdo->errorInfo());
			}

			if($uneGarde['gNbPompiers'] == 1){
				//delete
				$requete = "DELETE FROM garde WHERE gCis = $cis AND gDate = '$jour' AND gTranche = $tranche;";
			}else{
				//update
				
				$nbPompiers = $uneGarde['gNbPompiers']-1;
				$requete = "UPDATE garde SET  gNbPompiers = $nbPompiers WHERE gCis = $cis AND gDate = '$jour' AND gTranche = $tranche;";
			
			}
		}
		//requete garde
		$rs = PdoBD::$monPdo->exec($requete);
		if ($rs === false) {
			afficherErreurSQL("Probleme table garde " , $requete, PdoBD::$monPdo->errorInfo());
		}	

	



		
		/*
		$Garde= !$Garde;
		$req = "
		
				;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de la garde dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	*/
	
	}	
/**
	* Met à jour une ligne de la table pompier 
*/
	public function majPompier($cis,$valeur,$nom,$prenom,$statut,$mail,$login,$mdp,$grade,$adresse,$cp,$ville,$tel,$commentaire)
	{
		$req = "
		
		
		
				;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du pompier dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
/**
	* supprime une ligne de la table pompier 
*/
	public function supprimePompier($cis, $valeur)
	{
		$req = "DELETE 
				FROM pompier
				WHERE  pCis='$cis' AND pId='$valeur';";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression du pompier dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
/**
 * ajoute une ligne dans la table pompier
*/
	public function ajoutPompier($cis,$valeur,$nom,$prenom,$statut,$mail,$login,$mdp,$grade,$adresse,$cp,$ville,$tel,$commentaire)
	{			
		$req = "INSERT INTO pompier 
				(pCis,pId,pNom,pPrenom,pStatut,pMail,pLogin,pMdp,pGrade,pAdresse,pCp,pVille,pBip,pCommentaire,pDateEnreg,pDateModif) 
				VALUES 
					('$cis', '$valeur', '$nom', '$prenom', $statut, '$mail', '$login', '$mdp', $grade, '$adresse', $cp, '$ville', $tel,'$commentaire', NOW(), NOW());";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion du pompier dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
/**
 * Retourne les informations des gardes d'un pompier (ou des pompiers) sous la forme d'un tableau associatif
*/
	public function getInfosGardes($pompier)
	{
		$req = "SELECT aPompier, DATE_FORMAT(aDateGarde,'%d/%m/%Y') as wDate, aTranche, pLibelle as tLibelle
				FROM  activite INNER JOIN parametre ON pType='tranche' AND aTranche=pIndice
				WHERE aCis=".$_SESSION['cis'];
		if ($pompier<>"*") {
		$req .= " AND aPompier=".$pompier;}
		$req .= " AND aGarde=True
				ORDER BY aPompier, aDateGarde DESC, aTranche ASC;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des gardes d'un pompier...", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
/**
 * Retourne les informations des disponibilites hebdomadaires d'un pompier sous la forme d'un tableau associatif
*/
	public function getDisposHebdo($pompier,$semaine,$annee)
	{
		$sem=intval($semaine)-1;
		$premierJour = strtotime("+$sem weeks",mktime(0,0,0,1,1,$annee));
		if (date('w',$premierJour) != 1){$premierJour = strtotime("last monday",$premierJour);}
		$debut=date('Y/m/d',$premierJour);
		$fin=date('Y/m/d',strtotime("6 days",$premierJour));
		
		$req = "SELECT pId, pNom, pPrenom, DATE_FORMAT(aDateGarde,'%d/%m/%Y') as wDate, aTranche, aDisponibilite, aGarde, d.pValeur as dCouleur
				FROM (activite INNER JOIN parametre t ON t.pType='tranche'AND aTranche=t.pIndice
				INNER JOIN parametre d ON d.pType='dispo' AND aDisponibilite=d.pIndice)
				RIGHT OUTER JOIN pompier ON aCis=pCis AND aPompier=pId
				WHERE aCis=".$_SESSION['cis'];
		if ($pompier<>"*") {
		$req .= " AND aPompier=".$pompier;}
		$req .= " AND aDateGarde BETWEEN '".$debut."' AND '".$fin."'
				AND aDisponibilite>0
				ORDER BY aPompier, aDateGarde ASC, aTranche ASC;";
		//echo $req;
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des gardes d'un pompier...", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		
		$lesDispos = array();
		
		return $lesLignes;
		}
/**
 * Retourne true si une garde d'un pompier existe
 * 
*/
public function getGarde($jour, $tranche )
	{	
		$req = "SELECT gCis , gTranche, gDate , gNbPompiers FROM garde WHERE gCis=".$_SESSION['cis']." AND gDate='".$jour."' AND gTranche=".$tranche.";";
		
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des gardes d'un pompier...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetch();
		
		return $ligne ;
	}


	
			
/**
 * Retourne dans un tableau associatif les informations de la table tranche 
*/
	public function getLesTranches()
	{
		$req = "SELECT pIndice as tId, pLibelle as tLibelle
				FROM parametre WHERE pType='tranche'
				ORDER by 1;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des tranches dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}

/**
	 * Retourne les informations de la table typeParametre
	*/
	public function getLesParametres()
	{
		$req = "SELECT tpId, tpLibelle, tpBooleen, tpChoixMultiple
					FROM typeParametre
					ORDER BY tpLibelle;";
		$rs = PdoBD::$monPdo->query($req);
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}

/**
 * Retourne dans un tableau associatif les informations de la table PARAMETRE (pour un type particulier)
*/
	public function getParametre($type)
	{
		$req = "SELECT pIndice, pLibelle, pValeur, pPlancher, pPlafond
				FROM parametre
				WHERE pType='$type'
				ORDER by pIndice;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres ".$type." dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
	
		return $lesLignes;
	}

	/**
	 * Retourne dans un tableau associatifles informations de la table PARAMETRE (pour un type particulier)
	*/
	public function getInfosParam($type, $valeur)
	{	
		if ($valeur=="NULL") 
		{$req = "SELECT pType, max(pIndice)+1 AS pIndice, ' ' AS pLibelle, tpLibelle
					 FROM parametre INNER JOIN typeParametre ON typeParametre.tpId=parametre.pType
					 WHERE pType='$type';";
		}
		else
		{$req = "SELECT pType, pIndice, pLibelle, tpLibelle, pPlancher, pPlafond
					 FROM parametre INNER JOIN typeParametre ON typeParametre.tpId=parametre.pType
					 WHERE pType='$type'
					 AND pIndice='$valeur';";
		}		
		$rs = PdoBD::$monPdo->query($req);
		$ligne = $rs->fetch();		
		return $ligne;
	}

/**
 * Met a jour une ligne de la table PARAMETRE
*/
	public function majParametre($type, $valeur, $libelle, $plancher, $plafond)
	{
		$req = "UPDATE parametre SET pLibelle='$libelle', pPlancher='$plancher', pPlafond='$plafond'
					WHERE pType='$type'
					AND pIndice=$valeur;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la modification d'un parametre dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
/**
 * supprime une ligne de la table PARAMETRE 
*/
	public function supprimeParametre($type, $valeur)
	{
		$req = "DELETE 
					FROM parametre
					WHERE pType='$type'
					AND pIndice=$valeur;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression d'un parametre dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
/**
 * ajoute une ligne dans la table PARAMETRE
*/
	public function ajoutParametre($type, $valeur, $libelle, $plancher, $plafond)
	{	
		$req = "INSERT INTO parametre 
					(pType, pIndice, pLibelle, pPlancher, pPlafond) 
					VALUES ('$type', $valeur, '$libelle', $plancher, $plafond);";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion d'un parametre dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}


/**
 * envoyer un message electronique
*/
	public function envoyerMail($mail, $sujet, $msg, $entete)
	{			
		if (mail($mail, $sujet, $msg, null)==false)  
		{ echo 'Suite à un problème technique, votre message n a pas été envoyé a '.$mail.' sujet'.$sujet.'message '.$msg.' entete '.$entete;}
	}

/**
 * Retourne les informations d'une intervention
 */
	public function getInfosIntervention($intervention)
	{		
		$req = "SELECT iCis, iId, iLieu, iDescription, iDate , iTranche, iHeureDebut, iHeureFin
					FROM intervention
					WHERE iId=".$intervention.";";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture de l'intervention ...", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
/**
 * Retourne les informations de toutes les interventions d'une caserne
 */
	public function getLesInterventions($cis)
	{		
		$req = "S
		
		
		
		
				;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des interventions de la caserne ...", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	/**
 * Retourne les participants à une intervention
 */
	public function getLesParticipants($cis, $intervention)
	{		
		$req = "
		
		
		
				;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des participants ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
		
}

?>