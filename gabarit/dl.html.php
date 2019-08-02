<?php
defined( '_VALID_CORE_DL' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(!empty($dls)){
	foreach($dls as $dl){
		echo '<div class="topic_top"></div>
<div class="topic_middle">';
		echo '<h2><a href="index.php?comp=dl&amp;did='.$dl->did.'">'.stripslashes(htmlspecialchars($dl->name)).'</a></h2> <h4>&nbsp;</h4>';
		echo "<div class='newscontenu'>";
		echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($dl->description)))).'<br />';
		
		echo '<br /><center><a href="index.php?comp=dl&amp;did='.$dl->did.'"><img onmouseover="this.src=\'./templates/default/ico/download2.png\'" src="./templates/default/ico/download.png" onmouseout="this.src=\'./templates/default/ico/download.png\'" title="Télécharger : '.stripslashes(htmlspecialchars($dl->name)).'" alt="Télécharger : '.stripslashes(htmlspecialchars($dl->name)).'"/></a></center></div>';
		echo '</div><div class="topic_bottom"></div><br />';
	}
}
else{
	echo "Aucune fichier pour le moment";
}

require_once('./templates/'.$link_style.'bottom.php');
?>