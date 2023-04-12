<!-- affichage des erreurs / Derniere modification le 11 septembre 2016 par Pascal Blain -->

<div class ="erreur">
	<ul>
	<?php 
	foreach($_REQUEST['erreurs'] as $erreur)
		{
	      echo "<li>$erreur</li>";
		}
	?>
	</ul>
</div>