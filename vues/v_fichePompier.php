
<!-- affichage du detail de la fiche pompier / Derniere modification le 11/10/2018 à 22h31 par Pascal BLAIN -->

<?php 
$titre="Mes disponibilit&eacute;s";
echo ('
 	<div id="fiche">
		<ul class="lesOnglets">	
			<li class="actif onglet" 	id="onglet1" onclick="javascript:Affiche(\'1\',3);">'.$titre.'</li>
			<li class="inactif onglet" 	id="onglet2" onclick="javascript:Affiche(\'2\',3);">Mes gardes</li>
			<li class="inactif onglet" 	id="onglet3" onclick="javascript:Affiche(\'3\',3);">Mon profil</li>
		</ul>');
			
/*================================================================================================== DISPONIBILITEES (1) */
echo ("
		<div style='display: block;' class='unOnglet' id='contenuOnglet1'>
			<fieldset><legend>X indique une garde</legend>"); ?>
	<!-- div class="boite" style="margin: 0px 10px;" -->
	
		<form name="frmDispos" action="index.php?choixTraitement=pompiers&action=voir" method="post">	
			<input type="hidden" maxlength="2" name="zSemaine"	value='<?php echo $semaine;?>'>
			<input type="hidden" maxlength="2" name="zAnnee" 	value='<?php echo $annee;?>'>			
		</form>			
		<table id="tableau" class="tableau">
			<tbody>
			<tr>
				<th><input id="sPrecedente" name="gauche" title="semaine précédente" src="images/gauche.gif" onclick="autreSemaine('<?php echo date('W',strtotime("6 days",$premierJour))."', '".date('Y',strtotime("6 days",$premierJour));?>')" onmouseover="document.gauche.src='images/gauche_.gif'" onmouseout="document.gauche.src='images/gauche.gif'"type="image"></th>

				<th colspan="26"><b><big>Semaine <?php echo $semaine." : du lundi ".date('d/m/Y',$premierJour)." au dimanche ".date('d/m/Y',strtotime("6 days",$premierJour))."</big></b></th>";?>

				<th><input id="sSuivante" name="droite" title="semaine suivante" src="images/droite.gif" onclick="autreSemaine('<?php echo date('W',strtotime("14 days",$premierJour))."', '".date('Y',strtotime("14 days",$premierJour));?>')" onmouseover="document.droite.src='images/droite_.gif'" onmouseout="document.droite.src='images/droite.gif'"type="image"></th>
			</tr>
			<tr>
			<?php
			$nomJour = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
			for($jour=0; $jour<= 6; $jour++)
			{
			echo ('<th colspan="4">'.$nomJour[$jour].' '.date('d/m',strtotime('+'.$jour.' day',$premierJour)).'</th>');
			}
			?>			
			</tr>
			<tr>
			<?php
			for($jour=0; $jour<= 6; $jour++) 
			{	for($tranche=1; $tranche <=4; $tranche++){echo '<th class="semaine" style="text-align : center;">'.$tranche.'</th>';} 
			}
			?>
			</tr>	
			<tr>		
			<?php
				
				$ligne = 0;
			
				
				for($jour=0; $jour<= 6; $jour++) 
				{	
							
					for($tranche=1; $tranche <=4; $tranche++){
						echo '<td class="couleur" style="text-align : center; height:15px;"   >';
						$value = date('d/m',strtotime('+'.$jour.' day',$premierJour)).'/'.$annee.'_'.strval($tranche).'_0';
						$name = "gray";
							
						if($ligne < count($lesDispos))
						{ 
							if(  (substr($lesDispos[$ligne]['wDate'],0,5)  == date('d/m',strtotime('+'.$jour.' day',$premierJour)) )  &&  ($lesDispos[$ligne]['aTranche'] == strval($tranche)))
							{
								
								$value = $lesDispos[$ligne]['wDate'].'_'.$lesDispos[$ligne]['aTranche'].'_'.$lesDispos[$ligne]['aDisponibilite'];
								$name =  $lesDispos[$ligne]['dCouleur'];$ligne = $ligne + 1;
							
							}
						}
						
						echo '<button  class="disponible"  style="text-align : center;height:15px;width:10px; " type="text" name="'.$name.'"  value="'.$value.'"   onclick="disponibilite(this)" >    </button>';
						echo '</td>';
					} 
				}
			

			
			
			?>
			</tr>
			
			<?php 
			
			$lePompier	= $choix;
				echo '
			<script>
			
			for( var j = 0 ; j < 28 ; j++){
				var array = document.getElementsByClassName("disponible")[j].value.split("_");
				
				switch(parseInt(array[2])){
					case 0:
						document.getElementsByClassName("couleur")[j].style.background = document.getElementsByClassName("disponible")[j].name
						break;
					case 1:
						document.getElementsByClassName("couleur")[j].style.background = document.getElementsByClassName("disponible")[j].name
						break;
					case 2:
						document.getElementsByClassName("couleur")[j].style.background = document.getElementsByClassName("disponible")[j].name
						break;
					  
				}
			}
			
			var myId='.$_SESSION["idUtilisateur"].';
			var pId='.$choix.';
			var myStatut ='.$_SESSION["statut"].';
			if(myStatut == 2){
				if(myId != pId){
					for( var j = 0 ; j < 28 ; j++){
						document.getElementsByClassName("disponible")[j].disabled = true;
					 }
				}
			}
					

				
		
			
			</script>';
		
			?>		 	
		
			</tr>
			</tbody>
		</table>
		
		<?php
	
		echo ' 
			<!-- The Modal -->
			<div id="myModal" class="modal">

			<!-- Modal content -->
			<div class="modal-content">
			
				
				<form name="frmActivites" action="index.php?choixTraitement=pompiers&action=majActivite" method="post">
				<input type="hidden" name="zSemaine" value="'.$semaine.'" >
    			<input type="hidden" name="zAnnee" value="'.$annee.'">
        
				<h3 id="ztJour"> </h3>
					<span class="close">&times;</span>
					<input  id="ztLaDate" name="ztLaDate"   type="text" value="" hidden />
					<input id="ztLaTranche" name="ztLaTranche"  type="text" value=""  hidden/>
					<input id="ztExDispo" name="ztExDispo"  type="text" value="" hidden />
					<label name=""><input id="brDispo0" name="brDispo" type="radio" value="0" />Indispo</label>
					<label name="" ><input id="brDispo1" name="brDispo" type="radio" value="1"/>Dispo</label>
					<label name="" ><input id="brDispo2" name="brDispo" type="radio" value="2"/>Travail</label>
					<br />
					<input type="submit" value="valider"  />
					
				</form>
			</div>

			</div>';
	
			echo '
			<style> /* css */
			/* The Modal (background) */
			.modal {
			display: none; /* Hidden by default */
			position: fixed; /* Stay in place */
			z-index: 1; /* Sit on top */
			left: 0;
			top: 0;
			width: 100%; /* Full width */
			height: 100%; /* Full height */
			overflow: auto; /* Enable scroll if needed */
			background-color: rgb(0,0,0); /* Fallback color */
			background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
			}

			/* Modal Content/Box */
			.modal-content {
			background-color: #fefefe;
			margin: 15% auto; /* 15% from the top and centered */
			padding: 20px;
			border: 1px solid #888;
			width: 80%; /* Could be more or less, depending on screen size */
			}

			/* The Close Button */
			.close {
			color: #aaa;
			float: right;
			font-size: 28px;
			font-weight: bold;
			}

			.close:hover,
			.close:focus {
			color: black;
			text-decoration: none;
			cursor: pointer;
			}
			</style>
			';
			echo '
			<script>
			var span = document.getElementsByClassName("close")[0];
			var modal = document.getElementById("myModal");
			var btn_disponible = document.getElementsByClassName("disponible")[0];
			
			span.onclick = function() {
				modal.style.display = "none";
			  }
			 
			
				function disponibilite(uneDisponiblite){
						
					var array = uneDisponiblite.value.split("_");
					var date = array[0];
					var tranche = array[1];
					var dispo = array[2];
					majDispo(date,tranche,dispo);
					modal.style.display = "block";
					
				 }
				

			</script>';
		?>	
		</div>
	<!-- /div -->
<?php
echo ("
			</fieldset>
		</div>");
/*================================================================================================== GARDES (2)*/		

echo ("
		<div style='display: none;' class='unOnglet' id='contenuOnglet2'>
		<fieldset><legend>Gardes r&eacute;alis&eacute;es ");
	if (count($lesGardes)==0) {echo "<i>(aucune garde enregistrée)</i></legend>";} else					
{
	echo ("<i>(".count($lesGardes)." gardes)</i></legend>
			<table style='border: 0px solid white;'>
				<tr><th class='controleLong'>Date de la garde</th>");
	foreach ($lesTranches as $uneLigne)	{ echo ("<th>".$uneLigne['pLibelle']."</th>");}
	$dateGarde="premiere";
	$colonne=1;
	echo "</tr>";
	foreach ($lesGardes as $uneLigne)		
	{ 
		if ($dateGarde != $uneLigne['wDate'])
		{
			if ($dateGarde !=  "premiere")
			{
			while ($colonne<=count($lesTranches)) {echo "<td class='controle' style='text-align : center;'>&nbsp;</td>"; $colonne++;}
			echo "</tr>
			";			
			}
			echo "<tr><td class='controle' style='text-align : center;'>".$uneLigne['wDate']."</td>";
			$dateGarde = $uneLigne['wDate'];
			$colonne=1;
		}
		while ($colonne<$uneLigne['aTranche']) {echo "<td class='controle' style='text-align : center;'>&nbsp;</td>"; $colonne++;}
		echo ("<td class='controle' style='text-align : center;background-color : lime;'>&nbsp;</td>");
		$colonne=$uneLigne['aTranche']+1;
	}
	while ($colonne<=count($lesTranches)) {echo "<td class='controle' style='text-align : center;'>&nbsp;</td>"; $colonne++;}
	echo "</tr>";
	echo ("</table>");
}
echo ("
		</fieldset>
		</div>");

/*================================================================================================== COORDONNEES (3) */

 echo ("	
	 	<div style='display: none;' class='unOnglet' id='contenuOnglet3'> 
 			<table style='border: 0px solid white;'>
			<tr>
				<td style='border :0px;'>
				<fieldset><legend>Coordonn&eacute;es</legend>
					<table>
						<tr><th style='width:130px;'>Nom</th>		<td style='width:130px;'>".$lesInfosPompier['nom']."</td> </tr>
						<tr><th>Pr&eacute;nom</th>					<td>".$lesInfosPompier['prenom']."</td> </tr>
						<tr><th>Adresse</th>						<td>".$lesInfosPompier['pAdresse']."</td> </tr>
						<tr><th>Code postal</th>					<td>".$lesInfosPompier['pCp']."</td> </tr>
						<tr><th>Ville</th>							<td>".$lesInfosPompier['pVille']."</td> </tr>
						<tr><th>T&eacute;l&eacute;phone</th>		<td>".$lesInfosPompier['pBip']."</td> </tr>
						<tr><th>Adresse &eacute;lectronique</th>	<td>".$lesInfosPompier['pMail']."</td> </tr>
						<tr><th>Nom de compte</th>					<td>".$lesInfosPompier['pLogin']."</td></tr>
						<tr><th>&nbsp;</th>							<td>&nbsp;</td> </tr>
						<br />");
echo ("			</table>
				</fieldset>
				</td>	
				<td style='border :0px;'>
				<fieldset><legend>Centre d'Incendie et de Secours</legend> 
					<table>
						<tr><th style='width:130px;'>Code</th>		<td>".$lesInfosPompier['pCis']."</td> </tr>
						<tr><th>Nom</th>							<td>".$lesInfosPompier['cNom']."</td> </tr>
						<tr><th>Adresse</th>						<td>".$lesInfosPompier['cAdresse']."</td> </tr>
						<tr><th>T&eacute;l&eacute;phone</th>		<td>".$lesInfosPompier['cTel']."</td> </tr>
						<tr><th>Groupement</th>						<td>".$lesInfosPompier['cGroupement']."</td> </tr>
					</table>
				</fieldset>
				<fieldset><legend>Fonction</legend> 
					<table>
						<tr><th>Type</th>							<td>".$lesInfosPompier['wType']."</td> </tr>
						<tr><th>Grade</th>							<td>".$lesInfosPompier['wGrade']."</td> </tr>
						<tr><th>Statut</th>							<td>".$lesInfosPompier['wStatut']."</td> </tr>					</table>
				</fieldset></td>
			</tr>
			</table>
			
			<fieldset><legend>Observations</legend>
			<table style='border: 0px solid white;'>
				<tr> 
					 <td>.".$lesInfosPompier['pCommentaire']."</td>
				</tr>
			</table>
			</fieldset>
		</div>");

/*================================================================================================== Onglet X */
echo ("
		<div style='display: none;' class='unOnglet' id='contenuOngletX'>
			<fieldset><legend>XXXX</legend>
			<table>
				<tr><th style='width:130px;'>.....</th></tr>
				<tr><td>xxxx</td></tr>
			</table>
			</fieldset>
		</div>

	</div>
</div>");				
?>