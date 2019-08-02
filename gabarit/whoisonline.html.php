<?php
defined( '_VALID_CORE_WHOISONLINE' ) or die( 'Restricted access' );

echo 'Il y a '.$nb_online.' connectés ('.$nb_membres.' membres et '.$nb_visiteurs.' invités)<br /><br />';

if(!empty($connecte_membres)){
	echo '<table class="online">';
	foreach($connecte_membres as $object){
	
		$last_min = round((time()-$object->online_time)/60);
		echo '<thead><td><a href="index.php?comp=profil&amp;select='.$object->online_id.'">'.$object->pseudo.' ('.$last_min.' min)</a></td><td><a href="index.php?comp=mp_write&amp;to='.$object->online_id.'"><img src="./templates/default/ico/mponline.png" title="Ecrire un message privé"></a></td></thead>';
	}
	echo '</table>';
}

?>
<table class="online">
<td>
<script type="text/javascript">
<!--
var ouvert = 1;
var style = "headset";
var couleur_fond = "f9e7b5";
var couleur_texte = "540000";
var largeur = 130;
var hauteur = 350;
var ip = "evoxis.info";
var port = 8767;
var query = 51234;
var lang = "fr";
var taille_police = 12;
var voir_salons = 1;
var image = "http://www.evoxis.info/templates/default/main_pic/bg_news_titre.png";
//-->
</script>
<script type="text/javascript" src="http://www.ts-serveur.com/web_script/webscript.js"></script>
</td>
</table>