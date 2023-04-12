<!-- Derniere modification le 16 octobre 2018 par Pascal Blain -->
<div id="contenu">
<?php
 	if ($_REQUEST['action']=="supprimer") 
		{ 	echo '<h2>SUPPRESSION DU POMPIER '.$lesInfosPompier['nom'].' '.$lesInfosPompier['prenom'].'</h2>';
		 	echo '<form name="frmA" 	action="index.php?choixTraitement=pompiers&action=validerSupprimer&type='.$type.'&agent='.$lesInfosPompier['id'].'" method="post">';} 
 	if ($_REQUEST['action']=="modifier") 
		{ 	echo '<h2>MODIFICATION DU POMPIER '.$lesInfosPompier['nom'].' '.$lesInfosPompier['prenom'].'</h2>'; 	
			echo '<form name="frmA" 	action="index.php?choixTraitement=pompiers&action=validerModifier&type='.$type.'&agent='.$lesInfosPompier['id'].'" method="post">';}
 	if ($_REQUEST['action']=="ajouter") 
		{ 	echo "<h2>AJOUT D'UN NOUVEAU POMPIER</h2>";
			echo '
			<form name="frmA" 	action="index.php?choixTraitement=pompiers&action=validerAjouter&type='.$type.'" method="post" onsubmit="return valider(this)">';}
	echo ("	
    <table style='border: 0px solid white;'>
	<tr>
	<td style='border :0px;'>
	<fieldset><legend>Coordonn&eacute;es</legend>
		<table>");
	
$titre="Pr&eacute;nom";
 if ($_REQUEST['action']=="supprimer")  //-------------------------------------------------------- cas suppression
 {	echo ("
			<tr><th style='width:130px;'>Nom</th>	<td style='width:130px;'>".$lesInfosPompier['nom']."</td></tr>
			<tr><th>".$titre."</th>					<td>".$lesInfosPompier['prenom']."</td></tr>
			<tr><th>Adresse</th>					<td>".$lesInfosPompier['pAdresse']."</td></tr>
			<tr><th>Code postal</th>				<td>".$lesInfosPompier['pCp']."</td></tr>
			<tr><th>Ville</th>						<td>".$lesInfosPompier['pVille']."</td></tr>
			<tr><th>T&eacute;l&eacute;phone</th>	<td>".$lesInfosPompier['pBip']."</td></tr>					
			<tr><th>Adresse &eacute;lectronique</th><td>".$lesInfosPompier['pMail']."</td></tr>
			<tr><th>T&eacute;l&eacute;phone</th>	<td>".$lesInfosPompier['pTel']."</td></tr>
			<tr><th>Nom de compte</th>				<td>".$lesInfosPompier['pLogin']."</td></tr>
			<tr><th>Grade</th>						<td>".$lesInfosPompier['wGrade']."</td></tr>
			<tr><th>Statut</th>						<td>".$lesInfosPompier['wStatut']."</td></tr>
        </table>
    </fieldset>");	
	}
 else	//------------------------------------------------------------------------------------ cas ajout ou modification
	{
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
	
	}
echo ("	
	</td>
	</tr>
	</fieldset>
	</table>");
?>         
            <table style='border: 0px solid white; '>
            	<tr>
                <td style='border: 0px solid white;'>
                	<fieldset><legend>Observations</legend>
                 	<textarea name='ztObs' cols='70' rows='1'><?php echo $lesInfosPompier['agCommentaire'];?></textarea>
                	</fieldset>
                </td>
                <td style='border: 0px solid white; witdh:130px; text-align:right;'>
                	<input type="hidden" 	name="zTypeAdm"		value="<?php if ($type=="adm") {echo ("true");} else {echo ("false");} ?>"> 
                	<input type="hidden" 	name="zOk"			value="OK"> 

                </td>
                </tr>
            </table>         
    </form>
