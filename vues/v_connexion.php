<!-- connexion / Derniere modification le 11 septembre 2016 par Pascal Blain -->

<div id="contenu">
      <h2>Merci de vous identifier pour acc&eacute;der aux dossiers</h2>
	<form name="frmIdentification" method="POST" action="index.php?choixTraitement=connexion&action=valideConnexion">    
        <fieldset><legend>Identification utilisateur</legend>
            <br /><br />
               <label for="nom">Nom du compte*</label>
               <input id="login" 	type="text" 	name="login"  size="30" maxlength="45" 	placeholder="Entrez votre nom d'Utilisateur">
            </p>
            <p>
                <label for="mdp">Mot de passe&nbsp;&nbsp;&nbsp;&nbsp;*</label>
                <input id="mdp" 	type="password"  name="mdp" size="30" 	maxlength="45" 	placeholder="Entrez votre Mot de Passe">
            </p><br /><br />
                <input type="submit" 	name="valider"		value="Valider">
                <input type="reset" 	name="annuler" 		value="Annuler">
            </p>
        </fieldset>
	</form>
    <br /><br />
</div>
