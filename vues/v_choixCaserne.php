<!-- choix d'une Caserne / Derniere modification le 4 novembre 2016 par Pascal Blain -->
<?php
	$nbA=count($lesCasernes);
	echo '
 <div id="contenu">
	<form name="choixC" action="index.php" method="post">
	<h2>'.$titre; ?>
		<select name="lstCasernes" STYLE="width:350px;" onchange="submit();">
			<?php 
			if (!isset($_REQUEST['lstCasernes'])) {$choix = 'premier';} else {$choix =$_REQUEST['lstCasernes'];}

			$i=1; 
			foreach ($lesCasernes as $uneCaserne)
			{	
				if($uneCaserne['cId'] == $choix or $choix == 'premier')
					{echo "<option selected value=\"".$uneCaserne['cId']."\">".$uneCaserne['cNom']." ".$uneCaserne['cAdresse'].")</option>\n	";
					$choix = $uneCaserne['cId'];
					$noA=$i;}
				else
					{echo "<option value=\"".$uneCaserne['cId']."\">".$uneCaserne['cNom']." ".$uneCaserne['cAdresse'].")</option>\n		";
					$i=$i+1;}
			}	           
			echo '   
		</select>
	</h2>
		    <input type="hidden" name="choixTraitement" value="interventions">
		    <input type="hidden" name="action" value="'.$_REQUEST['action'].'">';
	        ?>
	        <!-- ============================================================== navigation dans la liste -->
	        <div id='navigation'>
		        <input type="image" id="zNouveau" title="Ajouter une Intervention" src="images/ajout.gif" onclick="ajouter('choixC')">
                <input type="image" id="zModif" title="Modifier une Intervention" src="images/modif.gif" onclick="modifier('choixC')">
                <input type="image" id="zSupprime" title="Supprimer une Intervention" src="images/supprimer.gif" onclick="supprimer('choixC')">&nbsp;&nbsp;
                <input type="image" id="zPremier" title="premier" src="images/goPremier.gif" onclick="premier('choixC','lstCasernes')">    
		        <input type="image" id="zPrecedent" title="pr&eacute;c&eacute;dent" src="images/goPrecedent.gif" onclick="precedent('choixC','lstCasernes')"> 
<?php echo '	<input type="text" id="zNumero" value="'.$noA.'/'.$nbA.'" disabled="true" size="5" style="text-align:center;vertical-align:top;">'; ?>
		        <input type="image" id="zSuivant" title="suivant" src="images/goSuivant.gif" onclick="suivant('choixC','lstCasernes')">    
		        <input type="image" id="zDernier" title="dernier" src="images/goDernier.gif" onclick="dernier('choixC','lstCasernes')">    
		    </div>
	</form>
<!-- fin liste de choix -->
