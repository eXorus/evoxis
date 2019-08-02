<?php
defined( '_VALID_CORE_NEWS_ARCHIVES' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(!empty($news_archives)){
	echo '<table class="tableau">';
	echo'
	<thead><tr>
		<th>Titre</th>
		<th>Auteur</th>
		<th>Date</th>
	</tr></thead>';
	foreach($news_archives as $one_news){
		echo '<tbody>
			<tr class="tr">
			<td align="left"><a href="index.php?comp=news_comment&amp;nid='.$one_news->nid.'">'.stripslashes(htmlspecialchars($one_news->title)).'</a></td>
			<td>'.$one_news->username.'</td>
			<td>'.$one_news->date_create.'</td>
			</tr></tbody>';
}
	echo '</table>';
echo '<p style="margin-top:3em; text-align:center; margin-right:20px;"><a href="index.php?comp=news">[ <<< Retour à la page d\'accueil ]</a></p>';
}
else{
	echo "Aucune news pour le moment";
}

require_once('./templates/'.$link_style.'bottom.php');

?>