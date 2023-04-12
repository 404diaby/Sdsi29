<!-- affichage de la feuille de gardes / Dernière modification le 18 octobre 2016 par Pascal BLAIN -->

<div style='display: block;' class='unOnglet' id='contenuOnglet1'>
	<fieldset><legend>Feuille de gardes</legend>
		<form name="frmGarde" >	
			<input type="hidden" maxlength="2" name="zSemaine"	value='<?php echo $semaine;?>' />
			<input type="hidden" maxlength="4" name="zAnnee" 	value='<?php echo $annee;?>' />	
			<input type="hidden" name="ztDate" value=""  />
			<input type="hidden" name="ztTranche" value=""  />
			<input type="hidden" name="ztGarde" value=""  />
			<input type="hidden" name="ztunPompier" value=""  />
		
		</form>			
		<table id="tableau" class="tableau">
			<tbody>
				<tr>																								
					<th><input id="sPrecedente" name="gauche" title="semaine précédente" src="images/gauche.gif" onclick="autreSemaine('<?php echo date('W',strtotime("-7 days",$premierJour))."', '".date('Y',strtotime("-7 days",$premierJour))?>')" type="image" /></th>

					<th colspan="28"><b><big>Semaine <?php echo $semaine." : du lundi ".date('d/m/Y',$premierJour)." au dimanche ".date('d/m/Y',strtotime("6 days",$premierJour))?></big></b></th>

					<th><input id="sSuivante" name="droite" title="semaine suivante" src="images/droite.gif" onclick="autreSemaine('<?php echo date('W',strtotime("14 days",$premierJour))."', '".date('Y',strtotime("+7 days",$premierJour));?>')" onmouseover="document.droite.src='images/droite_.gif'" onmouseout="document.droite.src='images/droite.gif'"type="image" /></th>
				</tr>
				<tr>
					<?php
						$nomJour = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
						echo ('<th rowspan="2">Volontaire</th>');
						echo ('<th rowspan="2">N° Bip</th>');
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
		
					<?php
				
							
						foreach ($lesPompiers as $unPompier) {
							$ligne = 0;		
							echo '<tr> <th name="'.$unPompier['pId'].'">'.$unPompier['pNom'].' '.$unPompier['pPrenom'].'</th>';
							echo '<th name="'.$unPompier['pBip'].'">'.$unPompier['pBip'].'</th>';
							$pompier = $lesDisposPompiers[$unPompier['pId']];//$unPompier['pId']];
							for($jour=0; $jour<= 6; $jour++) 
							{	
										
								for($tranche=1; $tranche <=4; $tranche++){
									echo '<td class="couleur" style="text-align : center; height:15px;"   >';
									$value = '0';
									$name = "gray";
									

										
									if($ligne < count($pompier))
									{ 
										if(  (substr($pompier[$ligne]['wDate'],0,5)  == date('d/m',strtotime('+'.$jour.' day',$premierJour)) )  &&  ($pompier[$ligne]['aTranche'] == strval($tranche)))
										{
											
											$value = $pompier[$ligne]['aDisponibilite'];
											$name =  $pompier[$ligne]['dCouleur'];
											$garde =  $pompier[$ligne]['wDate'].'_'.$pompier[$ligne]['aTranche'].'_'.$unPompier['pId'].'_'.$pompier[$ligne]['aGarde'];
											$ligne = $ligne + 1;
										
										}
									}



									echo '<button  class="disponible"  style="text-align : center;height:15px;width:10px; " type="text" name="'.$name.'" hidden value="'.$value.'"  >    </button>';
									if ( $value == 1 || $value == 2) {
										echo '<input  class="garde"  style="text-align : center;height:15px;width:10px; " type="checkbox" name="garde" value="'.$garde.'" onclick="myFonction(this)" ';
										$aGarde = explode("_",$garde);
										
										if($aGarde[3] == 1){
											echo' checked';
										}
										echo '/> ';
										;
									}

									echo'</td>';
									

									
								} 
							}
							echo'</tr>';
						}
					?>
						
			
				
		
			</tbody>
		</table>
			
		
		
		
	</fieldset>
</div>	
<script>
	var nbrDispo = document.getElementsByClassName('disponible').length;
						for( var j = 0 ; j < nbrDispo ; j++){
							var dispo = document.getElementsByClassName('disponible')[j].value;
							
							switch(parseInt(dispo)){
								case 0://indispo gris
									document.getElementsByClassName('couleur')[j].style.background =  document.getElementsByClassName('disponible')[j].name
									break;
								case 1:
									document.getElementsByClassName('couleur')[j].style.background =  document.getElementsByClassName('disponible')[j].name
									break;
								case 2://au travail jaune
									document.getElementsByClassName('couleur')[j].style.background = document.getElementsByClassName('disponible')[j].name
									break;
							}
						}
	function myFonction(uneGarde){
							var array = uneGarde.value.split('_');
							var laDate = array[0];
							var laTranche = array[1];
							var lePompier = array[2];
							var exGarde = array[3];
						
						
						//	majGarde(laDate, laTranche, exGarde, lePompier);		
				
		document.forms["frmGarde"].ztDate.value 		= laDate.substring(6) + "/" + laDate.substring(3,5) + "/" + laDate.substring(0,2);
		document.forms["frmGarde"].ztTranche.value	= laTranche;
		document.forms["frmGarde"].ztGarde.value 	= exGarde;
		document.forms["frmGarde"].ztunPompier.value 	= lePompier;
		//alert(document.forms["frmGarde"].ztLaDate.value);alert('envoyer');
		document.forms["frmGarde"].action	= "index.php?choixTraitement=gardes&action=majGarde";
		document.forms["frmGarde"].method	= "post";
		
		document.forms["frmGarde"].submit();
		
		}	
		</script>