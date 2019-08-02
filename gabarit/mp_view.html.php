<?php
defined( '_VALID_CORE_MP_VIEW' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

/****
* BARRE D'ACTIONS: Répondre, Modérer
*/
$barreActions = '<div id="nav_forum"><center><table class="nav_forum"><tr><td class="nav_forum_left"></td><td class="nav_forum_center"><div class="pagination">';

$barreActions .= '<a href="./index.php?comp=mp_write&amp;dpID='.$mps[0]->dpID.'"><img src="./templates/'.$link_style.'/ico/repondre.png" alt="Répondre"/></a>';

$barreActions .= '<span class="tooltip_forum"><img src="./templates/'.$link_style.'/ico/moderate.png" alt="Modération"/><em> ';

	$barreActions .= '
	<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="index.php?comp=mp_moderate&amp;action=moveFolder&amp;dpID='.$mps[0]->dpID.'">Déplacer dans un dossier</a><br />
	<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="index.php?comp=mp_moderate&amp;action=delete&amp;dpID='.$mps[0]->dpID.'">Supprimer</a><br />
	<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="index.php?comp=mp_moderate&amp;action=notread&amp;dpID='.$mps[0]->dpID.'">Marquer non-lu</a><br />';

$barreActions .= '</em><br /></span></div></td><td class="nav_forum_right"></td></tr></table></center></div>';



echo $barreActions;


echo '<h1>'.stripslashes(htmlspecialchars($mps[0]->dpTitle)).'</h1><h4>'.stripslashes(htmlspecialchars($mps[0]->dpUnderTitle)).'</h4>';

if(!empty($mps)){
	
	//Mef: Participants
	$printPart = '';
	$participants = explode(";",$mps[0]->participants);
	foreach ($participants as $participant){
		$part = explode('|', $participant);
		$printPart .= '<a href="./index.php?comp=profil&amp;select='.$part[0].'">';
		$printPart .= ($part[2]==0) ? '<span class="barre">' : '';
		$printPart .= stripslashes(htmlspecialchars($part[1])); 
		$printPart .= ($part[2]==0) ? '</span></a> ' : '</a> ';
	}
	echo 'Participants: '.$printPart.'<br /><br />';
		
	foreach($mps as $mp){
		echo '
			<div id="mpid'.$mp->mpID.'" class="blockCommentaire">
				<div class="blockCommentaireHeader">De '.$mp->pseudo.' le '.$mp->mpDateCreation.'</div>
				<div class="blockCommentaireBody">'.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($mp->mpMessage)))).'
					<div align="right">
						<a href="#top"><img src="./templates/'.$link_style.'/ico/topic_up.gif" height="20px" width="20px" align="top" title="Haut de page" alt="Haut de page"/></a>&nbsp;
						<a href="#bot"><img src="./templates/'.$link_style.'/ico/topic_down.gif" height="20px" width="20px" align="top" title="Bas de page" alt="Bas de page"/></a>
					</div>
				</div>
			</div>
			';
	}
	echo $barreActions;
}
else{
	echo "Aucun message";
}

require_once('./templates/'.$link_style.'bottom.php');
?>
