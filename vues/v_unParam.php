<!-- Derniere modification le 27 octobre 2013 par Pascal Blain -->
<div id="contenu">
<?php
 	if ($action==="supprimer") 
		{echo '<h2>SUPPRESSION DE LA VALEUR D\'UN PARAMETRE</h2>';
		 echo "<form name='frmParam' action='index.php?choixTraitement=parametres&action=validerSupprimer&type=".$infosParam['pType']."&valeur=".$infosParam['pIndice']."' method='post'>";} 
	if ($action==="modifier") 
		{echo '<h2>MODIFICATION DE LA VALEUR D\'UN PARAMETRE</h2>';
		 echo "<form name='frmParam' action='index.php?choixTraitement=parametres&action=validerModifier&type=".$infosParam['pType']."&valeur=".$infosParam['pIndice']."' method='post'>";}
	if ($action==="ajouter") 
		{echo '<h2>AJOUT DE LA VALEUR D\'UN PARAMETRE</h2>';
		 echo "<form name='frmParam' action='index.php?choixTraitement=parametres&action=validerAjouter&type=".$infosParam['pType']."' method='post'>";}
?>	
<!-- Affichage des valeurs dans un tableau r&eacute;capitulatif.  -->
        <div>
            <table style='border: 0px solid white;'>
            <tr><td style='border :0px;'>
                <fieldset><legend><?php echo $infosParam['tlLibelle'] ?></legend>
<?php
echo ("			<table>
                        <tr> <th>Indice</th>			<td>");
						if ($action==="ajouter") {echo "<input class='controle' type='text' name='valeur' value='".$infosParam['pIndice']."'>";}
						else {echo $infosParam['pIndice'];}  
echo ("				</td> </tr>
                        <tr> <th>Valeur</th>			<td>");
						if ($action==="ajouter") 		{echo "<input class='controle' type='text' name='zLibelle'>";$actif=null;}
						if ($action==="modifier") 	{echo "<input class='controleLong' type='text' name='zLibelle' value='".$infosParam['pLibelle']."'>";$actif=null;}
						if ($action==="supprimer") 	{echo $infosParam['pLibelle'];$actif="disabled='disabled'";}  
echo ("				</td> </tr>");
						echo ("
	  					<tr> <th>Plancher</th>			<td><input class='controle' type='text' name='zPlancher' value='".$infosParam['pPlancher']."'></td> </tr>						
						<tr> <th>Plafond</th>			<td><input class='controle' type='text' name='zPlafond' value='".$infosParam['pPlafond']."'></td> </tr>");
echo ("
	  				</table>
					<input type='hidden' name='zTerritoire' value='NULL'><input type='hidden' name='zDep' value='NULL'>"); ?>
                </fieldset>
                </td>	
            </tr>
            </table>
        </div>

        <p align="right">
            <input type="hidden" 	name="zOk" value="OK">
            <input type="image" 	name="btValider" alt="Valider" src="images/valider.jpg"  	onclick="this.form.submit();">
            <input type="image" 	name="btAnnuler" alt="Annuler" src="images/annuler.jpg" 	onclick="annuler('frmParam');">
        </p>   
    </form>
</div>