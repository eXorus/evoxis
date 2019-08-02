
<?php
defined( '_VALID_CORE_CHANGELOG' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>

<h1>ChangeLog</h1><h4>Evoxis <?php echo $ws_version ?></h4>

<h2>Version 4.0.7</h2><h4>[2009-05-21]</h4>
<ul>
	<li>Nouveau Bugtracker</li>
</ul><br />

<h2>Version 4.0.6</h2><h4>[2009-02-22]</h4>
<ul>
	<li>Admin: Ajout de l'�dition d'un lien dans le calendrier</li>
	<li>Ajout du type d'event (principal, secondaire, divers)</li>
</ul><br />

<h2>Version 4.0.5</h2><h4>[2009-01-20]</h4>
<ul>
	<li>Admin: Mise en place du module Wall</li>
	<li>Admin: Mise en place du module Ban</li>
	<li>Admin: Mise en place du module Stats</li>
	<li>Admin: Mise en place du module recherche sur les membres</li>
</ul><br />

<h2>Version 4.0.4</h2><h4>[2008-12-01]</h4>
<ul>
	<li>Mise en place d'un cache pour le module stats</li>
	<li>Correction d'une anomalie sur le nombre de requ�tes dans le footer</li>
	<li>R�organisation des box</li>
	<li>Nouvelle page de pr�sentation (page d'accueil)</li>
	<li>Affichage d'un avertissement pour les visiteurs sur la shoutbox</li>
	<li>Nouveau module: Guilde</li>
</ul><br />

<h2>Version 4.0.3</h2><h4>[2008-11-16]</h4>
<ul>
	<li>Remise en place de BGCheck</li>
</ul><br />

<h2>Version 4.0.2</h2><h4>[2008-09-30]</h4>
<ul>
	<li>Mise en place des sauvegardes automatiques journali�res et hebdomadaires</li>
	<li>Correction du changement des mots de passe</li>
	<li>Mise en place d'un panel de s�curisation pour les inscriptions</li>
	<li>Correction de bugs</li>
	<li>Am�lioration de la pagination</li>
</ul><br />

<h2>Version 4.0.1</h2><h4>[2008-09-22]</h4>
<ul>
	<li>Correction &amp; Robustesse du syst�me d'inscription (+r�ouverture)</li>
	<li>Ouverture d'infobox par d�faut</li>
	<li>Correction d'un bug sur le nb d'actifs</li>
	<li>Correction du nombre de connect� au site qui ne fonctionnait plus</li>
	<li>Correction de la synchronisation pour les BGs</li>
</ul><br />

<h2>Version 4.0</h2><h4>[2008-09-18]</h4>
<ul>
	<li>Ajout d'une Charte de r�gles � respecter pour s'inscrire</li>
	<li>Ajout du BBCode "Couleur"</li>
	<li>S�curisation des sessions MJs</li>
	<li>Refonte de l'interface MJ</li>
	<li>Refonte du syst�me de droits</li>
	<li>Ajout du temps moyen de validation d'un BG sur la page "Mes backgrounds"</li>
</ul><br />

<h2>Version 3.3</h2><h4>[2007-05-03]</h4>
<ul>
	<li>Lancement de la Beta Public</li>
	<li>Correction de bugs par centaines</li>
	<li>Page �quipe</li>
	<li>Finition de la console MJ pour l'inscription</li>
</ul><br />

<h2>Version 3.2</h2><h4>[2007-05-02]</h4>
<ul>
	<li>Syst�me BugTracker</li>
	<li>Refonte total du design, travail acharn� de Bisou, icones, ...</li>
	<li>Revision total du forum</li>
	<li>Ajout de level d'acc�s au forum</li>
	<li>Ajout d'un testeur de complexit� des mot de passes</li>
</ul><br />

<h2>Version 3.1.10</h2><h4>[2007-05-01]</h4>
<ul>
	<li>Syst�me de MP</li>
	<li>Correction de bug majeur dans le profil</li>
	<li>Revision de l'inscription</li>
</ul><br />

<h2>Version 3.1.7</h2><h4>[2007-04-28]</h4>
<ul>
	<li>Mise � jour du pathway pour le forum</li>
	<li>Ajout d'un die pour la perte de connexion avec MySQL</li>
	<li>Ajout d'un syst�me de fermeture du site</li>
	<li>Changement de toute les cl� INDEX en cl� PRIMAIRE, et passage du charset en iso-8859-1 au lieu de utf-8</li>
	<li>Revision de Dernier Message</li>
	<li>Syst�me lu/nonlu pour le forum</li>
	<li>Mes backgrounds importation et affichage</li>
</ul><br />

<h2>Version 3.1.6</h2><h4>[2007-04-27]</h4>
<ul>
	<li>Mise � jour sur la shoutbox, prise en compte du pseudo du connect�, affichage sur une ligne, rechargement sans AJAX, reste juste le sens.</li>
	<li>Possibilit� pour les admin de mettre un sujet en annonce.</li>
	<li>Restructuration des fichiers CSS</li>
	<li>Mise � jour du design des commentaires de news</li>
	<li>Ajout du chargement des droits d'acc�s au login, d�but</li>
</ul><br />

<h2>Version 3.1.5</h2><h4>[2007-04-26]</h4>
<ul>
	<li>S�curit�: Ajout des define pour index, core et gabarit</li>
	<li>S�curit�: Impossible de poster sans �tre connect�, de meme pour editer</li>
	<li>Ajout de l'avatar par defaut pour les comptes</li>
	<li>Nouveau design pour les posts</li>
	<li>Ajout de la table MySQL exo_indices</li>
	<li>Finition sur la barre de smileys pour poster, avec popup</li>
</ul><br />

<h2>Version 3.1.4</h2><h4>[2007-04-25]</h4>
<ul>
	<li>Images cat�gorie design fonctionne</li>
	<li>Pathway fonctionne</li>
	<li>Mise en place du design des formulaire par Bisou</li>
	<li>Mise en place du design du forum par Bisou, index et board</li>
	<li>Box en ligne</li>
</ul><br />

<h2>Version 3.1.3</h2><h4>[2007-04-24]</h4>
<ul>
	<li>Mise en place de l'espace profil: infos, avatar, signature, th�mes, ...</li>
	<li>Correction du bug sur la shoutbox, pour afficher les messages directement</li>
	<li>Mise en place du design des news par Bisou</li>
</ul><br />

<h2>Version 3.1.2</h2><h4>[2007-04-17]</h4>
<ul>
	<li>Mise en place du nouveau templates par Bisou</li>
	<li>Affichage des posts en div</li>
	<li>Ajout du JS pour le bbcode</li>
</ul><br />

<h2>Version 3.1.1</h2><h4>[2007-04-15]</h4>
<ul>
	<li>Mise en place du forum</li>
	<li>Affichage de l'index, des topics, des posts</li>
	<li>Possibilit�s de cr�er un topics et de r�pondre</li>
	<li>Ajout des stats, nb de message, nb de r�ponses, nb de lecture, dernier message</li>
</ul><br />

<h2>Version 3.1</h2><h4>[2007-04-14]</h4>
<ul>
	<li>Mise en place du multi design</li>
	<li>Syst�me de News</li>
	<li>Mise en place de l'espace administrateur</li>
	<li>Cr�ation d'un compte</li>
</ul><br />

<h2>Version 3.0</h2><h4>[2007-03-28]</h4>
<ul>
	<li>Mise en place de l'architecture</li>
	<li>Layer BDD</li>
	<li>Session</li>
	<li>Shoutbox</li>
</ul>

<?php
require_once('./templates/'.$link_style.'bottom.php');
?>