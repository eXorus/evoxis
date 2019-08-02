<?php
defined( '_VALID_CORE_FORUM_BOARD' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');


$start = intval($_GET['start']);

echo '<div id="nav_forum"><center><table class="nav_forum"><tr><td class="nav_forum_left"></td><td class="nav_forum_center"><div class="pagination">';

/****
*NAVIGATION
*/
if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$select.'_CREATE')==TRUE)
	$navigation_content .= '<a href="index.php?comp=forum_post&amp;action=newTopic&amp;bid='.$select.'"><img src="./templates/'.$link_style.'/ico/nouveau.png" alt="Nouveau sujet"/></a>&nbsp;';
if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$select.'_MODERATE')==TRUE && $_GET['mode']!="moderate")
	$navigation_content .= '<a href="./index.php?comp=forum_board&amp;select='.$select.'&amp;mode=moderate"><img src="./templates/'.$link_style.'/ico/moderate.png" alt="Moderate"/></a>&nbsp;';

echo $navigation_content;

echo ' 
<span class="tooltip_forum"><img src="./templates/'.$link_style.'/ico/filter.png" alt="Filtrer les topics"/>
<em>';

/****
*TAGS
*/
$moderate_options_tags = '';
foreach($tags as $tag){
	$moderate_options_tags .= '<option value="tagAdd_'.$tag->tag_id.'">'.htmlspecialchars($tag->title).' (add)</option><option value="tagDel_'.$tag->tag_id.'">'.htmlspecialchars($tag->title).' (del)</option>';	
	if(in_array($tag->tag_id, $_SESSION['ForumFilterArray'])){
		echo '<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="./index.php?comp=forum_board&amp;select='.$select.'&amp;filter='.$tag->tag_id.'&amp;filteraction=remove" title="'.$tag->description.'"><strong>'.str_replace(' ', '&nbsp;',htmlspecialchars($tag->title)).'</strong></a><br /> ';
	}
	else{
		echo '<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_not_selected.png" alt="Tag non sélectionné"/>&nbsp;<a href="./index.php?comp=forum_board&amp;select='.$select.'&amp;filter='.$tag->tag_id.'&amp;filteraction=add" title="'.$tag->description.'">'.str_replace(' ', '&nbsp;',htmlspecialchars($tag->title)).'</a><br /> ';
	}
	
}
echo '</em><br /></span>';

echo '</div></td><td class="nav_forum_right"></td></tr></table></center></div>';

/****
*MODERATION
*/
if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$select.'_MODERATE')==TRUE && $_GET['mode']=="moderate"){
	
	$moderate_options = '<div id="moderate_forum">	
					<select name="action">
					<option value="0" selected="selected">Action</option>

					<optgroup label="Générale">
					<option value="move">Déplacer</option>
					<option value="delete">Supprimer</option>
					<option value="merge">Fusionner</option>	
					<option value="notread">Marquer Non-Lu</option>
					</optgroup>
									
					<optgroup label="Verrouillage">
					<option value="unlock">Déverrouiller</option>
					<option value="lock">Verrouiller</option>
					</optgroup>
					
					<optgroup label="Type">
					<option value="announce">Annonce</option>
					<option value="standard">Standard</option>
					</optgroup>
					
					<optgroup label="Tag">
						'.$moderate_options_tags.'
					</optgroup>
					</select>
					<input type="submit" value="Valider" />
					</div>';
}
else{
		$moderate_options ="";
}

/****
*PAGINATION
*/
displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=forum_board&amp;select=".$select."&amp;start=", 30);

if(!empty($topics)){

	?>
	
	<form id="formod" method="post" action="./index.php?comp=forum_board_moderate&amp;bid=<?php echo $select; ?>">
	<div class="blocktable">
		
		<div class="box">
			<div class="inbox">
<?php echo $moderate_options; ?>
	<?php
	$currentTopicType = 999;
	foreach($topics as $topic){
		
		if($currentTopicType != $topic->type){
			echo '			
			<table class="fofotable"><thead><tr>';
			
			if($currentTopicType == 999 && $secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$select.'_MODERATE')==TRUE && $_GET['mode']=="moderate"){
				$endTab ='<th class="ft3" scope="col">Auteur</th><th class="ft3" scope="col">Réponses</th><th class="ft3" scope="col">Vues</th><th class="ft4" scope="col">Dernier message</th>
				<th class="ft4" scope="col">Sélection <input name="tous" id="idtous" onclick="cocheTous(\'caseModeration\', this.checked);" type="checkbox" /></th></tr></thead><tbody>';
			}
			elseif($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$select.'_MODERATE')==TRUE && $_GET['mode']=="moderate"){
				$endTab ='<th class="ft3" scope="col">Auteur</th><th class="ft3" scope="col">Réponses</th><th class="ft3" scope="col">Vues</th>
				<th class="ft4" scope="col">Dernier message</th><th class="ft4" scope="col">Sélection <input name="tous" id="idtous" onclick="cocheTous(\'caseModeration\', this.checked);" type="checkbox" /></th></tr></thead><tbody>';
			}
			else{
				$endTab ='<th class="ft3" scope="col">Auteur</th><th class="ft3" scope="col">Réponses</th><th class="ft3" scope="col">Vues</th><th class="ft4" scope="col">Dernier message</th></tr></thead><tbody>';
			}
			
			$currentTopicType = $topic->type;
			if($topic->type==1){
				echo '<th class="ft2" scope="col">'.stripslashes(htmlspecialchars($topics[0]->board_name)) .' - Annonces</th>'.$endTab;
			}
			else{
				echo '<th class="ft2" scope="col">'.stripslashes(htmlspecialchars($topics[0]->board_name)).'</th>'.$endTab;
			}
			

			
		}
		
		//ICONE: lu, non lu, lock
		if($topic->locked==1){
			$ico_l = '<div class="topic_message_closed">&nbsp;</div>';
			$lu = '_closed';
		}
		else if($topic->m_last_read<$topic->m_pid || empty($topic->m_last_read)){
			$ico_l = '<div class="topic_message_nonlu">&nbsp;</div>';
			$lu = '_nonlu';
		}
		else{
			$ico_l = '<div class="topic_message_lu">&nbsp;</div>';
			$lu = '_lu';
		}
		
		//Build Subject
		$subject_build = stripslashes(htmlspecialchars($topic->subject));
		
		//Tags
		if($topic->listeTags!=';'){
			$tagTopic = 'Tags : ';
			$listags = explode(';', $topic->listeTags);
			foreach($listags as $onetag){
				$datatag = explode('|', $onetag);
				$tagTopic .= '[<a class="tag" href="index.php?comp=forum_board&amp;select='.$select.'&amp;start=0&amp;filter='.$datatag[0].'">'.htmlspecialchars($datatag[1]).'</a>] ';
			}
		}
		else{
			$tagTopic = '';
		}
		
		if($topic->type==1){
			echo '<tr class="tr_announce">
			<td class="ft2">'.$ico_l.'<img src="./templates/'.$link_style.'/ico/starfull.png" alt="Annonce"/>&nbsp;<a class="topic_announce'.$lu.'" href="index.php?comp=forum_topic&amp;select='.$topic->tid.'&amp;start=0">'.$subject_build.'</a>
			<p class="board_details"><br /> 
			le '.format_time($topic->s_time).'<br />
			'.$tagTopic.'</p></td>';
		}
		else{
				echo '<tr class="tr">
			<td class="ft2">'.$ico_l.'<a class="topic'.$lu.'" href="index.php?comp=forum_topic&amp;select='.$topic->tid.'&amp;start=0">'.$subject_build.'</a>
			<p class="board_details"><br /> 
			le '.format_time($topic->s_time).'<br />
			'.$tagTopic.'</p></td>';
		}

		
		$auteurToPrint = ($topic->cat_rp==1) ? (empty($topic->s_bg_guid)) ? 'Anonyme' : '<a class="par" href="./index.php?comp=bg_show&amp;guid='.$topic->s_bg_guid.'">'.stripslashes(htmlspecialchars($topic->s_bg_name)).'</a>' : '<a class="par" href="./index.php?comp=profil&amp;select='.$topic->s_uid.'">'.stripslashes(htmlspecialchars($topic->s_name)).'</a>';
			
		echo '<td class="ft3"><center>'.$auteurToPrint.'</center></td>';
		echo '<td class="ft3"><center>'.$topic->nb_replies.'</center></td>';
		echo '<td class="ft3"><center>'.$topic->nb_views.'</center></td>';		
		if(!empty($topic->m_time)){
			
			$dmToPrint = ($topic->cat_rp==1) ? (empty($topic->m_bg_guid)) ? 'Anonyme' : '<a href="./index.php?comp=bg_show&amp;guid='.$topic->m_bg_guid.'">'.stripslashes(htmlspecialchars($topic->m_bg_name)).'</a>' : '<a href="./index.php?comp=profil&amp;select='.$topic->m_uid.'">'.stripslashes(htmlspecialchars($topic->m_name)).'</a>';
			
			echo '<td class="ft4"><center>'.format_time($topic->m_time).'<br />'.$dmToPrint.'&nbsp;<a href="index.php?comp=forum_topic&amp;select='.$topic->tid.'&amp;goto='.$topic->m_last_read.'#pid'.$topic->m_last_read.'"><img src="./templates/'.$link_style.'/ico/last.png" alt="Aller au dernier message" title="Aller au dernier message" onmouseover="Tip(\'Aller au dernier message\')" onmouseout="UnTip()"/></a></center></td>';
		}
		else{
			echo '<td class="ft4"><center>no data</center></td>';
		}
		
		
		if($_GET['mode']=="moderate"){
			echo '<td class="ft4"><center><input type="checkbox" name="tid_'.$topic->tid.'" /></center></th></tr></thead><tbody>';
		}
		
		echo '</tr>';
		
	}
	echo '</tbody></table></div></div></div></form>';

}


else{
	echo '<br />Aucun sujet à afficher<br />';
}

displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=forum_board&amp;select=".$select."&amp;start=", 30);
echo '<br /><br />';
echo '<div id="nav_forum"><center><table class="nav_forum"><tr><td class="nav_forum_left"></td><td class="nav_forum_center"><div class="pagination">';
echo $navigation_content;
echo '</div></td><td class="nav_forum_right"></td></tr></table></center></div>';

require_once('./templates/'.$link_style.'bottom.php');

?>
<script language="javascript">

function cocheTous(nameCheckBoxes, valeur)
{
var cases = document.getElementsByTagName('input');

	for(var i=1; i<cases.length; i++){
		if(cases[i].type == 'checkbox'){
				cases[i].checked = valeur;
		}
	}
}
</script>
