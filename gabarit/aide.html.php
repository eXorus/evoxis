<?php
defined( '_VALID_CORE_AIDE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
if(!empty($_GET['task']) && $_GET['task']=='tuto' && !empty($_GET['select'])){
	echo '<h1>'.stripslashes(htmlspecialchars($one_tuto['titre'])).'</h1><h4><a href="./index.php?comp=aide">Retour</a></h4>
	'.stripslashes(nl2br(parse_bbcode_smiley($one_tuto['body']))).'
	<h4><a href="./index.php?comp=aide">Retour</a></h4>'	;
}
else{

	if(!empty($tutos)){
		echo '<h1>Aide</h1><h4>Ou comment jouer sur Evoxis</h4>';
echo '<center>
<img onmouseover="this.src=\'./templates/default/main_pic/aide_faq2.png\'" src="./templates/default/main_pic/aide_faq.png" onmouseout="this.src=\'./templates/default/main_pic/aide_faq.png\'" title="Question fr�quentes" alt="Question fr�quentes"/>
<img onmouseover="this.src=\'./templates/default/main_pic/aide_inscription2.png\'" src="./templates/default/main_pic/aide_inscription.png" onmouseout="this.src=\'./templates/default/main_pic/aide_inscription.png\'" title="Aide � l\'inscription" alt="Aide � l\'inscription"/>
<img onmouseover="this.src=\'./templates/default/main_pic/aide_wow2.png\'" src="./templates/default/main_pic/aide_wow.png" onmouseout="this.src=\'./templates/default/main_pic/aide_wow.png\'" title="Aide � l\'installation de WoW" alt="Aide � l\'installation de WoW"/>
<img onmouseover="this.src=\'./templates/default/main_pic/aide_rp2.png\'" src="./templates/default/main_pic/aide_rp.png" onmouseout="this.src=\'./templates/default/main_pic/aide_rp.png\'" title="Aide au Role-Play" alt="Aide au Role-Play"/>
<img onmouseover="this.src=\'./templates/default/main_pic/aide_site2.png\'" src="./templates/default/main_pic/aide_site.png" onmouseout="this.src=\'./templates/default/main_pic/aide_site.png\'" title="Aide � l\'utilisation du site Web" alt="Aide � l\'utilisation du site Web"/>
</center>';
echo'<ul>';
		foreach($tutos as $tuto){
			echo '<li><a href="index.php?comp=aide&amp;task=tuto&amp;select='.$tuto->aid.'">'.stripslashes(htmlspecialchars($tuto->titre)).'</a></li>';
		}
		echo '</ul>';
	}

	echo '<br />';
}
require_once('./templates/'.$link_style.'bottom.php');
?>