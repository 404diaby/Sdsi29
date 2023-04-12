<!-- choix d'un parametre / Derniere modification le 16 octobre 2016 par Pascal Blain -->
<?php
	$nbP=count($lesParametres);
	echo '
 <div id="contenu">
	<form name="choixP" action="index.php?choixTraitement=parametres&action=voir" method="post">
	<h2>'.$titre; ?>
	        <select name="lstParam" STYLE="width:350px;" onchange="submit();">
	            <?php 
	            if (!isset($_REQUEST['lstParam'])) {$choix = 'premier';} else {$choix =$_REQUEST['lstParam'];}

	            $i=1; 
	            foreach ($lesParametres as $unParametre)
				{	
					if($unParametre['tpId'] == $choix or $choix == 'premier')
						{echo "<option selected value=\"".$unParametre['tpId']."\">".$unParametre['tpLibelle']."</option>\n	";
						$choix = $unParametre['tpId'];
						$titre1= $unParametre['tpLibelle'];
						$noP=$i;
						}
					else
						{echo "<option value=\"".$unParametre['tpId']."\">".$unParametre['tpLibelle']."</option>\n		";
						$i=$i+1;}
				}
			if ($_REQUEST['action']<>"liste") {$action = $_REQUEST['action'];} else {$action = "voir";}	
			    echo '   
	        </select></h2>
		    <input type="hidden"	name="uc" 				value="param">
		    <input type="hidden" 	name="action" 			value="'.$action.'">
        	<input type="hidden" 	name="zType"			value="*">
            <input type="hidden" 	name="zIndice"			value="0">
            <input type="hidden" 	name="zColonne"		value="0">';		
	        ?>
	        <!-- ============================================================== navigation dans la liste -->
	        <div id='navigation'>
                <input type="image" id="zPremier" title="premier" src="images/goPremier.gif" onclick="premier('choixP','lstParam')">    
		        <input type="image" id="zPrecedent" title="pr&eacute;c&eacute;dent" src="images/goPrecedent.gif" onclick="precedent('choixP','lstParam')"> 
<?php echo '	<input type="text" id="zNumero" value="'.$noP.'/'.$nbP.'" disabled="true" size="5" style="text-align:center;vertical-align:top;">'; ?>
		        <input type="image" id="zSuivant" title="suivant" src="images/goSuivant.gif" onclick="suivant('choixP','lstParam')">    
		        <input type="image" id="zDernier" title="dernier" src="images/goDernier.gif" onclick="dernier('choixP','lstParam')">    
		    </div>
	</form>

<!-- fin liste de choix -->