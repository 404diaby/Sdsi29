<!-- choix d'un pompier / Derniere modification le 11 septembre 2016 par Pascal Blain -->
<?php
	$nbL=count($lesLignes); 
	echo ' 
 <div id="contenu">
	<form name="choixP" action="index.php?choixTraitement=pompiers&action=voir" method="post">
	<h2>'.$titre; ?>
	        <select name="lstPompiers" STYLE="width:350px;" onchange="submit();">
	            <?php 
	            if (!isset($_REQUEST['lstPompiers'])) {$choix = $_SESSION['idUtilisateur'];} else {$choix =$_REQUEST['lstPompiers'];}
	            $i=1; 
	            foreach ($lesLignes as $uneLigne) 
				{	
					if($uneLigne['pId'] == $choix)
						{echo "<option selected value=\"".$uneLigne['pId']."\">".$uneLigne['pNom']." ".$uneLigne['pPrenom']."</option>\n	";
						$choix = $uneLigne['pId'];
						$noL=$i;
						}
					else
						{
						if ($_SESSION['statut']==2)
						{echo "<option value=\"".$uneLigne['pId']."\">".$uneLigne['pNom']." ".$uneLigne['pPrenom']."</option>\n		";}
						$i=$i+1;
						}
				}	           
			    echo '   
	        </select>			
			</h2>
	        <!-- ============================================================== navigation dans la liste -->
			<div id="navigation">';
	        if ($_SESSION['statut']==2)
			{?>

		        <input type="image"	id="zNouveau" 	title="Ajouter" 	src="images/ajout.gif" 		onclick="faire('choixP', 'ajouter')">
                <input type="image"	id="zModif" 	title="Modifier" 	src="images/modif.gif" 		onclick="faire('choixP', 'modifier')">
                <input type="image"	id="zSupprime" 	title="Supprimer"	src="images/supprimer.gif" 	onclick="faire('choixP', 'supprimer')">&nbsp;&nbsp;
                <input type="image"	id="zPremier" 	title="premier" 	src="images/goPremier.gif" 	onclick="premier('choixP','lstPompiers')">    
		        <input type="image" id="zPrecedent" title="pr&eacute;c&eacute;dent" src="images/goPrecedent.gif" onclick="precedent('choixP','lstPompiers')"> 
			<?php
			echo '	
				<input type="text" 	id="zNumero" value="'.$noL.'/'.$nbL.'" disabled="true" size="5" style="text-align:center;vertical-align:top;">'; ?>
		        <input type="image" id="zSuivant" 	title="suivant" 	src="images/goSuivant.gif" 	onclick="suivant('choixP','lstPompiers')">    
		        <input type="image"	id="zDernier" 	title="dernier" 	src="images/goDernier.gif" 	onclick="dernier('choixP','lstPompiers')">    
		    <?php
			}?>
			</div>
			
            <input type="hidden"	name="action"	value="<?php if($_REQUEST['action']=="liste") {echo "voir";} else {echo $_REQUEST['action'];}?>">
           <!-- <input type="hidden"	name="type" 	value="<?php echo $_REQUEST['type']?>">!-->
        	<input type="hidden"	name="zType"	value="*">
        	<input type="hidden"	name="zIndice"	value="*">
            <input type="hidden"	name="zColonne"	value="*">
	</form>
<!-- fin liste de choix -->
