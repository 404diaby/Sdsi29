<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
       "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <title>SDIS29</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="./styles/styles.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico" />
  	<script src="include/proceduresJava.js" type="text/javascript"></script>
  </head>
<?php 
	if (isset($_REQUEST['zFormulaire']))	{$formulaire=$_REQUEST['zFormulaire'];} 
	if (isset($_REQUEST['zChamp']))			{$champ		=$_REQUEST['zChamp'];}
?>	
  <body onload="donner_focus('<?php echo $formulaire."','".$champ;?>');">
    <div id="page">
		<div id="entete">
	        <img src="./images/logo.png" id="logo" alt="SDIS29" title="SDIS 29" />
	        <div id="sommaire">
<?php if (isset($_SESSION['idUtilisateur'])) 
		{echo '<ul>';
		 if ($_SESSION['statut']==2) 
			{echo '
			<li><a href="index.php?choixTraitement=parametres&action=voir" title="parametres">parametres</a>|</li>
			<li><a href="index.php?choixTraitement=gardes&action=voir" title="gardes">gardes</a>|</li>';}
		 if ($_SESSION['statut']==3) 
			{echo '
			<li><a href="index.php?choixTraitement=interventions&action=voir" title="interventions">interventions</a>|</li>';}
			echo '
			<li><a href="index.php?choixTraitement=pompiers&action=voir&type=a">pompiers</a>|</li>
			<li><b>Bienvenue '.$_SESSION['prenom'].'  '.strtoupper($_SESSION['nom']).' </b></li>
			<li style="text-align:left;"><a href="index.php?choixTraitement=connexion&action=demandeConnexion" title="Se d&eacute;connecter"><img alt="déconnexion" src="images/deconnexion.png" border="0" height="26px"></a></li>
			</ul>';
		}
?> 
				<h1>SDIS29 : gestion des gardes et des interventions</h1>
			</div>
<?php if (isset($_SESSION['adr1'])) 
		{echo '			
			<div><small><p style="text-align:left;">'.$_SESSION['adr1'].'<br />'.$_SESSION['adr2'].'<br />'.$_SESSION['adr3'].'<br />'.$_SESSION['adr4'].'</p></small>
			</div>';}?>
		</div>
<!-- fin affichage du menu -->