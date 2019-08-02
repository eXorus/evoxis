<?php
defined( '_VALID_CORE_RP_BG_VIEW' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(!empty($sections)){
	foreach($sections as $section){
		
	echo '<h1>'.stripslashes(htmlspecialchars($sections[0]->name)).'</h1><h4>'.stripslashes(htmlspecialchars($section->title)).'<br />Ecrit le : '.format_time($section->date_create).'</h4></div>
		<strong>Résumé du chapitre:</strong> <i>'.stripslashes(nl2br(htmlspecialchars($sections[0]->resume))).'</i>
		<br />';
	}
	foreach($sections as $section){
		echo "<div id='newscontenu'>";
		echo '
		<p>'.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($section->body)))).'</p>
		<i>Dernière Modification: '.format_time($section->date_edit).'</i></div>
		';
	}
}
else{
	echo 'Aucun Contenu disponible pour le moment';
}

require_once('./templates/'.$link_style.'bottom.php');

?>