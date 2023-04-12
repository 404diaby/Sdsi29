<!-- affichage du detail d'un parametre / Derniere modification le 16 octobre 2013 par Pascal BLAIN -->
<?php
echo(' 	
	<div id="fiche">
				');
/*==================================================================================================  */
echo("		
		<div>
			<fieldset><legend>Parametre</legend>
			<table>
				<tr><th style='width:25px;text-align:center;'><a href='index.php?choixTraitement=parametres&action=ajouter&type=".$enteteParametre['tpId']."&valeur=NULL'><img title='Ajouter une valeur' src='images/ajout.gif'></a></th><th style='width:30px;'>Code</th><th>Description</th></tr>
				<tr><td>&nbsp;</td><td>".$enteteParametre['tpId']."</td><td>".$enteteParametre['tpLibelle']."</td></tr>
			</table>
			</fieldset><br />
			
			<table style='border: 0px solid white;'>
			<tr>
				<td style='border :0px;'>
				<fieldset><legend>Valeurs</legend>
					<table>");
					$numPa=1;
					foreach ($lesInfosParametre as $uneLigne)
					{
						if ($numPa<9)
						{$numPa=$numPa+1;
						$type	=	$choix;
						$indice	=	$uneLigne['pIndice'];
						$table	=	$uneLigne['table'];
						echo("<tr> <th style='width:25px;text-align:center;'>".$uneLigne['pIndice']."</th>	<td>".$uneLigne['pLibelle']."</td>
								<td style='width:25px;text-align:center;'>");
						if ($uneLigne['nb']<>0 and ($table=="usager" or $table=="accompagnement")) 
							{echo("<a onclick=\"javascript:voirListe('$type','$indice','voir'); return false;\" class='stNb'>".$uneLigne['nb']."</a>");}
						else 
							{echo($uneLigne['nb']);}
						echo("</td>
								<td style='width:20px;text-align:center;'><a href='index.php?choixTraitement=parametres&action=modifier&type=".$enteteParametre['tpId']."&valeur=".$uneLigne['pIndice']."'><img src='images/modif.gif'  title='modifier'></a></td>
								<td style='width:20px;text-align:center;'>");
						if ($uneLigne['nb']!=0) {echo "&nbsp;";}
						else {echo ("						
						<a href='index.php?choixTraitement=parametres&action=supprimer&type=".$enteteParametre['tpId']."&valeur=".$uneLigne['pIndice']."'><img title='Supprimer' src='images/supprimer.gif'></a>");}
						echo ("
						</td></tr>");
						}
					}
					while ($numPa<9)
					{
						echo("<tr> <th style='width:25px;'>...</th>					<td>&nbsp;</td> </tr>");
						$numPa=$numPa+1;
					}

echo("				</table>
				</fieldset></td>
				<td style='border :0px;'>
				<fieldset><legend>(suite)</legend>
					<table>");
					$numP=1;
					foreach ($lesInfosParametre as $uneLigne)
					{
						if ($numP>=9)
						{
						$type	=	$choix;
						$indice	=	$uneLigne['pIndice'];
						$table	=	$uneLigne['table'];							
						echo("<tr> <th style='width:25px;text-align:center;'>".$uneLigne['pIndice']."</th>	<td>".$uneLigne['pLibelle']."</td>
								<td style='width:25px;text-align:center;'>");
						if ($uneLigne['nb']<>0 and ($table=="usager" or $table=="accompagnement")) 
							{echo("<a onclick=\"javascript:voirListe('$type','$indice','voir'); return false;\" class='stNb'>".$uneLigne['nb']."</a>");}
						else 
							{echo($uneLigne['nb']);}
						echo("</td>
								<td style='width:20px;text-align:center;'><a href='index.php?choixTraitement=parametres&action=modifier&type=".$enteteParametre['tpId']."&valeur=".$uneLigne['pIndice']."'><img src='images/modif.gif'  title='modifier'></a></td>
								<td style='width:20px;text-align:center;'>");
						if ($uneLigne['nb']!=0) {echo "&nbsp;";}
						else {echo ("
								<a href='index.php?choixTraitement=parametres&action=supprimer&type=".$enteteParametre['tpId']."&valeur=".$uneLigne['pIndice']."'><img title='Supprimer' src='images/supprimer.gif'></a>");}
						echo ("
						</td></tr>");
						}
						$numP=$numP+1;
					}
					if ($numP<9) {$numP=9;}
					while ($numP<17)
					{
						echo("<tr> <th style='width:25px;text-align:center;'>...</th>					<td>&nbsp;</td> </tr>");
						$numP=$numP+1;
					}
echo("				</table>
				</fieldset>
				</td>	
			</tr>
			</table>
			<fieldset><legend>Observations</legend>
				<table style='border: 0px solid white;'>
					<tr> 
						 <td>...</td>
					</tr>
				</table>
			</fieldset>			
		</div>
	</div>");				
?>