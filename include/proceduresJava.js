// version modifiée le 11 octobre 2018 par Pascal Blain
var ongletActif=1;
// =========================  passer le focus à un champ
function donner_focus(frm,champ)	{
		document.forms[frm].elements[champ].focus();
	}  
// =========================  fonction gestion de la fenetre de saisie d'une disponibilité
function majDispo(laDate, laTranche, exDispo)	{
		document.getElementById("ztJour").innerHTML	= laDate + " tranche " + laTranche;
		document.getElementById("brDispo" + exDispo).checked=true;
		if (exDispo==0) {document.getElementById("brDispo1").checked=true;}
		if (exDispo==1) {document.getElementById("brDispo0").checked=true;}
		document.forms["frmActivites"].ztLaDate.value 	= laDate.substring(6) + "/" + laDate.substring(3,5) + "/" + laDate.substring(0,2);
		document.forms["frmActivites"].ztLaTranche.value= laTranche;
		document.forms["frmActivites"].ztExDispo.value 	= exDispo;
		//location.href="#fenetreDispo";
	}
// =========================  fonction gestion des gardes
function majGarde(laDate, laTranche, exGarde, lePompier)	{
	alert();
		document.forms["frmGarde"].ztLaDatee.value 		= laDate.substring(6) + "/" + laDate.substring(3,5) + "/" + laDate.substring(0,2);
		document.forms["frmGarde"].ztLaTranchee.value	= laTranche;
		document.forms["frmGarde"].ztExGardee.value 	= exGarde;
		document.forms["frmGarde"].ztPompiere.value 	= lePompier;
		alert(document.forms["frmGarde"].ztLaDate.value);
		//document.forms["frmGarde"].action	= "index.php?choixTraitement=gardes&action=majGarde";
		document.forms["frmGarde"].method	= "get";
		document.forms["frmGarde"].submit();
	}
// =========================  fonction de navigation dans le calendrier des dispos
function autreSemaine(semaine, annee)	{
		document.forms["frmDispos"].zSemaine.value 	= semaine;
		document.forms["frmDispos"].zAnnee.value 	= annee;
		document.forms["frmDispos"].submit();
	}
// ========================= fonctions de navigation dans la liste de choix
function premier(frm, liste)	{
		document.forms[frm].elements[liste].value = document.forms[frm].elements[liste].options[0].value;
		document.forms[frm].submit();
	}	
function precedent(frm, liste)	{
		document.forms[frm].elements[liste].value = document.forms[frm].elements[liste].options[Math.max(0,document.forms[frm].elements[liste].selectedIndex-1)].value;
		document.forms[frm].submit();
	}	
function suivant(frm, liste)	{
		document.forms[frm].elements[liste].value = document.forms[frm].elements[liste].options[(Math.min((document.forms[frm].elements[liste].options.length-1),document.forms[frm].elements[liste].selectedIndex+1))].value;
		document.forms[frm].submit();
	}	
function dernier(frm, liste)	{
		document.forms[frm].elements[liste].value = document.forms[frm].elements[liste].options[(document.forms[frm].elements[liste].options.length-1)].value;
		document.forms[frm].submit();
	}
// =========================	
function faire(frm, action)	{ 
		document.forms[frm].action.value = action;
		if(action=="supprimer") {alert("ATTENTION : \n demande de suppression  \n cette action est irreversible !");}
		document.forms[frm].submit();
	}
// =========================
function validerAutre(frm, ordreAc, ordreCe, onglet)
{	
	document.getElementById("zOrdreAc").value=ordreAc;
	document.getElementById("zOrdreCe").value=ordreCe;
	document.getElementById("zOnglet").value=onglet;
	document.forms[frm].submit(); 
}
// =========================
function voirListe(type, indice, colonne)
{	
	document.forms["choixP"].zType.value=type;
	document.forms["choixP"].zIndice.value=indice;
	document.forms["choixP"].zColonne.value=colonne;
	document.forms["choixP"].action.value = "liste";
	document.forms["choixP"].submit(); 
}

// ========================= fonction annulation de saisie ou modification
function annuler(frm){
			document.forms[frm].elements["zOk"].value="nonOk";
			document.forms[frm].submit();
	}

// ========================= validation des données d'un usager	(version 2)
function validerUsager(frm)
{	//var champ=frm.elements["ztNom"]; 
	if(!verifTexte(frm, frm.elements["ztNom"], 40)) 	{return false;}
	else {if(!verifTexte(frm, frm.elements["ztPrenom"], 24)) 	{return false;}
			else {if(!verifMail(frm, frm.elements["ztEMail"])) 	{return false;}
					else {return true;} 
			}
	}
}
// =========================
function verifMail(frm, champ)
{
   var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
   if(regex.test(champ.value) || champ.value.length<1) 
   		{surligne(champ, false); return true;} 
   else 
   		{surligne(champ, true); return false;}
}
// ========================= fonctions de controle de validité d'un champ
function surligne(frm, champ, erreur)
{
   if(erreur) 
   		{champ.style.backgroundColor = "#f55"; alert("Champ '"+champ.id+"' incorrect ...\nMerci de corriger"); document.getElementById(champ.id).focus(); frm.elements["zOk"].value="nonOk";} 
   else 
   		{champ.style.backgroundColor = "#fff"; frm.elements["zOk"].value="OK";}
}

// ========================= fonctions de controle de validité d'un champ texte (longueur)
function verifTexte(frm, champ,longueur)
{
	if(champ.value.length < 2 || champ.value.length > longueur) 
   		{surligne(frm, champ, true); return false;} 
	else 
		{surligne(frm, champ, false); return true;}
}
// ========================= fonctions de controle de validité du code postal
function verifCP(frm, champ)
{	var str 		= champ.value;
	var insee 	= str.substring(0,5);
	var dep 	= str.substring(0,2);
	var cPostal	= str.substring(6,11);
	var secteur= str.substring(12,16);
	var ville 	= str.substring(17,57);
	var cp 		= parseInt(cPostal);
	if(isNaN(cp) || cp < 1000 || cp > 99999) {surligne(frm, champ, true); alert(cp); return false;} //   
	else { surligne(frm, champ, false); 		
			frm.elements["ztCP"].value				=cPostal;
			frm.elements["ztVille"].value			=ville;
			frm.elements["ztCommune"].value	=insee;
			frm.elements["departement"].value	=dep;
			if(frm.name="frmUsager") 
				{	
					for (var i=0;i<frm.elements["ldrSecteur"].length;i++) 
					{
						if(frm.elements["ldrSecteur"].options[i].value==secteur) {frm.elements["ldrSecteur"].selectedIndex=i; i=9999;}
					}
				}
			return true;}
}
// ========================= fonctions de controle de validité d'une date
function verifDate(laDate)
{
      var ok=true;
      var d=laDate.value;
	  laDate.style.backgroundColor="#fff";
      if(d != null && d != "")
      {
		  var amini=1900; // année mini
		  var amax=2030; // année maxi
		  var separateur="/"; // séparateur entre jour/mois/annee
		  var j=(d.substring(0,2));
		  var m=(d.substring(3,5));
		  var a=(d.substring(6));
	
		  if ( ((isNaN(j))||(j<1)||(j>31)) && (ok==1) ) {alert(j+" n'est pas un jour correct..."); laDate.style.backgroundColor="#f55"; ok=false;}
		  if ( ((isNaN(m))||(m<1)||(m>12)) && (ok==1) ) {alert(m+" n'est pas un mois correct ..."); laDate.style.backgroundColor="#f55"; ok=false;}
		  if ( ((isNaN(a))||(a<amini)||(a>amax)) && (ok==1) ) {alert(a+" n'est pas une année correcte: utiliser 4 chiffres, \n elle doit être comprise entre "+amini+" et "+amax); laDate.style.backgroundColor="#f55"; ok=false;}
		  if ( ((d.substring(2,3)!=separateur)||(d.substring(5,6)!=separateur)) && (ok==1) ) {alert("Les séparateurs doivent être des "+separateur); laDate.style.backgroundColor="#f55"; ok=false;}
		  if (ok==true) {
			 var d2=new Date(a,m-1,j);
			 j2=d2.getDate();
			 m2=d2.getMonth()+1;
			 a2=d2.getFullYear();
			 if (a2<=100) {a2=1900+a2}
			 if ( (j!=j2)||(m!=m2)||(a!=a2) ) {alert("La date "+d+" n'existe pas !"); laDate.style.backgroundColor="#f55"; ok=false;}
		  }
      }
      return ok;
}
// ========================= formate un nombre avec 2 chiffres après la virgule et un espace separateur de milliers
function format_euro(valeur) {
	var ndecimal=2;
	var separateur=' ';
	var deci=Math.round( Math.pow(10,ndecimal)*(Math.abs(valeur)-Math.floor(Math.abs(valeur)))) ; 
	var val=Math.floor(Math.abs(valeur));
	if ((ndecimal==0)||(deci==Math.pow(10,ndecimal))) {val=Math.floor(Math.abs(valeur)); deci=0;}
	var val_format=val+"";
	var nb=val_format.length;
	for (var i=1;i<4;i++) 
	{
		if (val>=Math.pow(10,(3*i))) 
		{
			val_format=val_format.substring(0,nb-(3*i))+separateur+val_format.substring(nb-(3*i));
		}
	}
	if (ndecimal>0) 
	{
		var decim=""; 
		for (var j=0;j<(ndecimal-deci.toString().length);j++) {decim+="0";}
		deci=decim+deci.toString();
		val_format=val_format+","+deci;
	}
	if (parseFloat(valeur)<0) {val_format="-"+val_format;}
	return val_format;
}

// ========================= affiche l'onglet choisi 
 function Affiche(ongletChoisi, nb)
{	
	for(i=1;i<nb+1;i++)
	{
		document.getElementById('onglet'+i).className = 'inactif onglet';
		document.getElementById('contenuOnglet'+i).style.display = 'none';
	}
	document.getElementById('onglet'+ongletChoisi).className = 'actif onglet';
	document.getElementById('contenuOnglet'+ongletChoisi).style.display = 'block';

	document.getElementById('zOnglet').value=ongletChoisi;
	document.getElementById('zNbOnglets').value=nb;
	ongletActif=ongletChoisi;
}
// ========================= transfert des données d'une liste à une autre
function deplacer_elements(frm, origine, destination) { 
	if (origine.options.selectedIndex >= 0) 
	{
		while (origine.options.selectedIndex >= 0) 								/* boucle tant qu'il reste des éléments sélectionnés */	
		{
			valeur = origine.options[origine.options.selectedIndex].value;		/* valeur de l'élément sélectionné */
			texte = origine.options[origine.options.selectedIndex].text;		/* texte de l'élément sélectionné */ 
			origine.options[origine.options.selectedIndex] = null;				/* suppression de l'element selectione dans la liste d'origine */
			destination.options[destination.options.length] = new Option(texte, valeur);/* ajout dans la liste destination */
		}
		var nbElements=destination.length;
		var tbl = new Array(nbElements, 2)
	
		for(ligne=0;ligne<nbElements;ligne++){
		tbl[ligne] = new Array(destination.options[ligne].text, destination.options[ligne].value);			
		}
		tbl.sort(triAlpha);
		destination.options.length=0;											/* efface la liste */
		for(ligne=0;ligne<nbElements;ligne++){
			destination.options[destination.options.length]=new Option(tbl[ligne][0],tbl[ligne][1]);		//rempli la liste avec les données triées
		}
	}
	else
		alert("choisissez au moins un participant !");
	return(false);
}
// =========================
function triAlpha(a,b) {
	a = a[0];
	b = b[0];
	return a == b ? 0 : (a < b ? -1 : 1)
}
// =========================
function tester(frm, liste) {
	var nbElements=liste.length;
	var tbl = new Array(nbElements, 2)

	for(ligne=0;ligne<nbElements;ligne++){
		tbl[ligne] = new Array(liste.options[ligne].text, liste.options[ligne].value);
		//alert("Valeur : " + tbl[ligne][1] + " Texte :" + tbl[ligne][0]);				
	}
	tbl.sort(triAlpha);
	liste.options.length=0;							//efface la liste
	for(ligne=0;ligne<nbElements;ligne++){
		liste.options[liste.options.length]=new Option(tbl[ligne][0],tbl[ligne][1]);		//rempli la liste avec les données triees
		// alert("Valeur : " + tbl[element,1] + " libellé : " + tbl[element,0]);
	}
	result = tbl.join('\n');
	alert(result);	
	return (false);
}
// =========================trouver un code postal en france, ou une commune
// parametres d'entrée : (L'un des 2 champs ne doit pas être vide. Sinon, c'est Paris qui est pris par défaut.)
// - codePostal : l'ID du champs contenant le code postal
// - ville : l'ID du champs contenant le nom de la commune
 
function openCodesPostaux(codePostal, ville){
	leCodePostal = document.getElementById(codePostal).value;
	laVille = document.getElementById(ville).value;
	if(laVille == ""){	laVille = leCodePostal;}
	window.open( 'http://www.codes-postaux.org/outils/module.php?Choix=' + escape(laVille) ,'CodePostal','scrollbars=yes, width=300, height=550');
}