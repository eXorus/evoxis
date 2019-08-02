<?php
defined( '_VALID_CORE_FORUM_TOPIC' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

/****
* BARRE D'ACTIONS: Répondre, Modérer
*/
$barreActions = '<div id="nav_forum"><center><table class="nav_forum"><tr><td class="nav_forum_left"></td><td class="nav_forum_center"><div class="pagination">';
if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$posts[0]->board_id.'_REPLY')==TRUE && $posts[0]->locked==0){
	$barreActions .= '<a href="index.php?comp=forum_post&amp;action=newPost&amp;tid='.$select.'"><img src="./templates/'.$link_style.'/ico/repondre.png" alt="Répondre"/></a>';
	$barreActionsLock = '<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="index.php?comp=forum_board_moderate&amp;action=lock&amp;tid='.$posts[0]->tid.'">Verrouiller</a><br />';
}
else{
	$barreActions .= '<img src="./templates/'.$link_style.'/ico/locked.png" alt="Verrouillé"/>';
	$barreActionsLock = '<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="index.php?comp=forum_board_moderate&amp;action=unlock&amp;tid='.$posts[0]->tid.'">Déverrouiller</a><br />';
}
$barreActions .= '<span class="tooltip_forum"><img src="./templates/'.$link_style.'/ico/moderate.png" alt="Modération"/><em> ';
if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$posts[0]->board_id.'_MODERATE')==TRUE){
	$barreActions .= '
	<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="index.php?comp=forum_post&amp;action=editTopic&amp;pid='.$posts[0]->first_post_id.'&amp;tid='.$posts[0]->tid.'">Modifier</a><br />
	<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="index.php?comp=forum_board_moderate&amp;action=move&amp;tid='.$posts[0]->tid.'">Déplacer</a><br />
	<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="index.php?comp=forum_board_moderate&amp;action=delete&amp;tid='.$posts[0]->tid.'">Supprimer</a><br />
	'.$barreActionsLock.'
	<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="index.php?comp=forum_topic&amp;mode=moderate&amp;select='.$posts[0]->tid.'">Messages</a><br />';
}
elseif($posts[0]->p_uid==$_SESSION['uid']){
	$barreActions .= '
	<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="index.php?comp=forum_post&amp;action=editTopic&amp;pid='.$posts[0]->first_post_id.'&amp;tid='.$posts[0]->tid.'">Modifier</a><br />';
}

$barreActions .= '<img class="select_tag" src="./templates/'.$link_style.'/ico/tag_selected.png" alt="Tag sélectionné"/>&nbsp;<a href="index.php?comp=forum_board_moderate&amp;action=notread&amp;tid='.$posts[0]->tid.'">Marquer Non-Lu</a><br />
</em><br /></span></div></td><td class="nav_forum_right"></td></tr></table></center></div>';


/****
* Liste des tags du sujet
*/
if($posts[0]->listeTags!=';'){
	$tagTopic = 'Tags : ';
	$listags = explode(';', $posts[0]->listeTags);
	foreach($listags as $onetag){
		$datatag = explode('|', $onetag);
		$tagTopic .= '[<a href="index.php?comp=forum_board&amp;select='.intval($posts[0]->board_id).'&amp;filter='.$datatag[0].'&amp;filteraction=add">'.htmlspecialchars($datatag[1]).'</a>] ';
	}
}
else{
	$tagTopic = '';
}



//Affichage de la barre d'actions
echo $barreActions;

if(!empty($posts)){
	
	//Pagination	
	displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=forum_topic&amp;select=".$select."&amp;start=", 30);
	echo '<a href="#bot">Bas de page</a>';
	
	//Sujet
	echo '<div class="topic_top_std"></div><div class="topic_middle_std"><div id="titre_topic">'.stripslashes(htmlspecialchars($posts[0]->topic_subject)).'<br /><p>'.$tagTopic.'</p></div></div><div class="topic_bottom_std"></div>';
	
	//Sondage
	$diff_timestamp = $posts[0]->post_time+$posts[0]->pNbDays*24*3600-time();
	
	if(empty($posts[0]->pNbDays)){
		$endOfPoll = "<center>Ce sondage est illimité dans le temps</center>";
		if($posts[0]->pAgain==1 && $_GET['mode']!="modifvote" && $nbr_vote!=0) $endOfPoll .= '<a href="./index.php?comp=forum_topic&amp;select='.$select.'&amp;start=0&amp;mode=modifvote">Changer mon précédent vote</a><br />';
		
	}
	else{
		if($diff_timestamp>0){
				$diff_j = floor($diff_timestamp/(24*60*60));
				$diff_timestamp = $diff_timestamp - $diff_j*24*60*60;
				$diff_h = floor($diff_timestamp/(60*60));
				$diff_timestamp = $diff_timestamp - $diff_h*60*60;
				$diff_m = floor($diff_timestamp/(60));
				$diff_timestamp = $diff_timestamp - $diff_m*60;
				$diff_s = floor($diff_timestamp);
				$endOfPoll = "<center>Encore ";
				if(!empty($diff_j)) $endOfPoll .= $diff_j."j ".$diff_h."h ".$diff_m."min ".$diff_s."s pour voter</center>";
				elseif(!empty($diff_h)) $endOfPoll .= $diff_h."h ".$diff_m."min ".$diff_s."s pour voter</center>";
				elseif(!empty($diff_m)) $endOfPoll .= $diff_m."min ".$diff_s."s pour voter</center>";
				elseif(!empty($diff_s)) $endOfPoll .= $diff_s."s pour voter</center>";
			
			
			if($posts[0]->pAgain==1 && $_GET['mode']!="modifvote" && $nbr_vote!=0) $endOfPoll .= '<a href="./index.php?comp=forum_topic&amp;select='.$select.'&amp;start=0&amp;mode=modifvote">Changer mon précédent vote</a><br />';
		}
		else{
			$endOfPoll = "<center>Ce sondage est clos, vous ne pouvez plus voter</center>";
		}
	}
	
	
	if(!empty($polls)){
		echo '<div class="topic_top_std"></div><div class="topic_middle_std"><div id="blockFormulaire"><div class="newscontenu">'.$endOfPoll.'<br />';
		
		if($printMode=="FORM"){		
			echo '<form method="post" name="formulaire" action="./index.php?comp=forum_topic&amp;task=process"><input type="hidden" name="pID" value="'.$polls[0]->pID.'" />';
			$currentQ = 0;
			echo '<table class="tableau">';
			foreach($polls as $poll){
				if($currentQ != $poll->pqID){
					//Nouvelle question
					echo '<thead><tr><th colspan="2">';
					echo ''.stripslashes(htmlspecialchars($poll->pqTitle)).'';
					
					$reponseValue = ($poll->pqMaxReponse>1) ? 'réponses' : 'réponse';
					echo '<br /><p style="font:12px normal;color:#555;">Vous devez sélectionner <b>'.$poll->pqMaxReponse.' '.$reponseValue.'</b></em>';
					$currentQ = $poll->pqID;	
							echo '</th></tr></thead>';
				}

				echo '<tbody><tr><td class="sondageq">';
				//Nouvelle réponse	
				$checkedOrNot = (empty($poll->paDate)) ? '' : 'checked="checked"';
				if($poll->pqMaxReponse>1){
					echo ''.stripslashes(htmlspecialchars($poll->pcTitle)).'</td><td class="sondager"><input type="checkbox" name="pollChoiceCheckbox_'.$poll->pcLink.'_'.$poll->pcID.'" '.$checkedOrNot.' />';		
				}
				else{
					echo ''.stripslashes(htmlspecialchars($poll->pcTitle)).'</td><td class="sondager"><input type="radio" name="pollChoiceRadio_'.$poll->pcLink.'" value="'.$poll->pcID.'" '.$checkedOrNot.' />';
				}	
				echo '</td></tr></tbody>';
			}
			echo '</table><input type="submit" name="submit" value="Envoyer"/></form>';
		}
		else{
			$currentQ = 0;
			$currentReponse = array();
			$currentVote = 0;
			echo '<table class="tableau">';
			
			foreach($polls as $poll){
				if($currentQ != $poll->pqID){
					//Nouvelle question
					foreach($currentReponse as $value){
						$vote = (!empty($currentVote)) ? floor($value['nbvote']/$currentVote * 100) : 0;
						echo '<tbody><tr><td class="sondageq">'.$value['titre'].' ('.$value['nbvote'].')</td><td class="sondager"><div class="pollbar_l"></div><div class="pollbar" style="width: '.$vote.'%;">'.$vote.'%</div><div class="pollbar_r"></div></td></tr></tbody>';
					}
					
					$currentReponse = array();
					$currentVote = 0;
					
					echo '<thead><tr><th colspan="2">'.stripslashes(htmlspecialchars($poll->pqTitle)).'</th></tr></thead>';
					
					$currentQ = $poll->pqID;
				}

				//Nouvelle réponse
				$temp = array(
					'titre' => stripslashes(htmlspecialchars($poll->pcTitle)),
					'nbvote' => $poll->nbvote
					);	
				$currentVote = $currentVote + $poll->nbvote;
				array_push($currentReponse, $temp);
					
			}
			
			foreach($currentReponse as $value){
				$vote = (!empty($currentVote)) ? floor($value['nbvote']/$currentVote * 100) : 0;
				echo '<tbody><tr><td class="sondageq">'.$value['titre'].' ('.$value['nbvote'].')</td><td class="sondager"><div class="pollbar_l"></div><div class="pollbar" style="width: '.$vote.'%;">'.$vote.'%</div><div class="pollbar_r"></div></td></tr></tbody>';
			}
			echo '</table>';
		}
		echo '</div></div></div><div class="topic_bottom_std"></div>';
	}
	
	
	echo '<form id="formod" method="post" action="./index.php?comp=forum_topic_moderate&amp;tid='.$posts[0]->tid.'">';
	
	//Moderation
	if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$posts[0]->board_id.'_MODERATE')==TRUE){
	echo '<div id="moderate_forum">	
				<select name="action">
				<option value="0" selected="selected">Action</option>

				<option value="moderate">Modérer</option>
				<option value="delete">Supprimer</option>
				<option value="report">Reporter</option>	
				<option value="split">Séparer</option>	
				
				</select>
				<input type="submit" value="Valider" />
				</div>';
	}


	foreach($posts as $post){
		
		if(!empty($post->messageType)){
				echo '<div id="pid'.$post->pid.'" class="topic_top_delete"></div><div class="topic_middle_delete"><br />';
				
				if($post->messageType=='POST_DELETED'){
					echo 'Message supprimé le '.$post->messageDate.' pour le motif suivant: '.$post->messageBody;
				}
				elseif($post->messageType=='POST_MODERATED'){
					echo 'Message modéré le '.$post->messageDate.' pour le motif suivant: '.$post->messageBody;
				}				
				echo '<br /></div><div class="topic_bottom_delete"></div>';
			
		}
		else{
			
	
	$moderationPostBar = '<a href="index.php?comp=forum_post&amp;action=newPost&amp;tid='.$select.'&amp;pid='.$post->pid.'">Quote</a>&nbsp;&nbsp;';
	
	if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$posts[0]->board_id.'_MODERATE')==TRUE || $post->p_uid==$_SESSION['uid']){
			$moderationPostBar .= '<a href="index.php?comp=forum_post&amp;action=editPost&amp;pid='.$post->pid.'">Modifier</a>&nbsp;&nbsp;';
	}
	$moderationPostBar .= '<a href="index.php?comp=forum_topic_moderate&amp;action=report&amp;pid='.$post->pid.'">Report</a>&nbsp;&nbsp;';
		
	if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$posts[0]->board_id.'_MODERATE')==TRUE){
		$moderationPostBar .= '
			<a href="index.php?comp=forum_topic_moderate&amp;action=moderate&amp;pid='.$post->pid.'">Modérer</a>&nbsp;&nbsp;
			<a href="index.php?comp=forum_topic_moderate&amp;action=delete&amp;pid='.$post->pid.'">Effacer</a>&nbsp;&nbsp;
			<a href="index.php?comp=forum_topic_moderate&amp;action=split&amp;pid='.$post->pid.'">Séparer</a>&nbsp;&nbsp;
			<label for="pid_'.$post->pid.'">Select: </label><input type="checkbox" name="pid_'.$post->pid.'" id="pid_'.$post->pid.'"/>';
	}
	
	//Affichage du pseudo
		//Sexe
		if($post->sexe==1){$pseudoColor = '#0000FF';}
		else{$pseudoColor = '#FF00FF';}
		
		//Group
		if($post->gid==1){$pseudoGroup = 'ADMIN';}
		elseif($post->gid==2 || $post->gid==5){$pseudoGroup = 'RP';}
		elseif($post->gid==3 || $post->gid==8){$pseudoGroup = 'TECH';}
		elseif($post->gid==4 || $post->gid==9){$pseudoGroup = 'WELCOME';}
		else{$pseudoGroup = 'MEMBRE';}

		//Group infobulle
		if($post->gid==1){$pseudoGroupInfo = 'Administrateur';}
		elseif($post->gid==2 || $post->gid==5){$pseudoGroupInfo = 'MJ&nbsp;Role&nbsp;Play';}
		elseif($post->gid==3 || $post->gid==8){$pseudoGroupInfo = 'MJ&nbsp;Technique';}
		elseif($post->gid==4 || $post->gid==9){$pseudoGroupInfo = 'MJ&nbsp;Welcome';}
		else{$pseudoGroup = 'MEMBRE';}

		//Affichage topics selon groupe membres
		if($post->gid==1 || $post->gid==2 || $post->gid==3 || $post->gid==4 || $post->gid==5 || $post->gid==8 || $post->gid==9)
		{$affiche_topic = 'mj';}
		else
		{$affiche_topic = 'std';}
	
	if($post->cat_rp==1){
		$pseudo = (empty($post->bg_guid)) ? '<span class="pseudo_text">Anonyme</span>' : '<span class="pseudo_text"><a href="./index.php?comp=bg_show&amp;guid='.$post->bg_guid.'">'.stripslashes(htmlspecialchars($post->bg_name)).'</a></span>';
		$avatar = (empty($post->bg_img_id)) ? '<img src="./img/pictures/0.png" alt="Avatar"/>' : '<img src="./img/pictures/'.$post->bg_img_id.'.'.$post->bg_img_ext.'" alt="Avatar"/>';
		$avatar_link = '';
	}
	else{
		$pseudo = '<span class="pseudo_text" style="color: '.$pseudoColor.';"><a href="./index.php?comp=profil&amp;select='.$post->p_uid.'">'.stripslashes(htmlspecialchars($post->p_name)).'</a></span>';
		$avatar = (empty($post->bg_img_id)) ? '<img src="./img/pictures/0.png" alt="Avatar"/>' : '<img src="./img/pictures/'.$post->avatarID.'.'.$post->avatarExtID.'" alt="Avatar"/>';
		$avatar_link = '<br />
<a href="index.php?comp=profil&amp;select='.$post->p_uid.'" onmouseover="Tip(\'Profil\')" onmouseout="UnTip()"><img class="bt_box" src="./templates/'.$link_style.'/main_pic/forum_profil.png" alt="Profil"/></a>
<a href="index.php?comp=mp_write&amp;to='.urlencode($post->username).'" onmouseover="Tip(\'Ecrire&nbsp;un&nbsp;message&nbsp;privé\')" onmouseout="UnTip()"><img class="bt_box" src="./templates/'.$link_style.'/main_pic/forum_messagerie.png" alt="Ecrire un message"/></a> 
<a href="index.php?comp=bg&amp;select='.$post->p_wow_id.'" onmouseover="Tip(\'Backgrounds\')" onmouseout="UnTip()"><img class="bt_box" src="./templates/'.$link_style.'/main_pic/forum_bgs.png" alt="Backgrounds"/></a>
';
	}
	

echo '
<div class="topic_top_'.$affiche_topic.'"></div>
<div class="topic_middle_'.$affiche_topic.'">
	<div class="blockPostHeaderAvatar">';

echo '
<div class="box_forum_avatar_top_'.$affiche_topic.'">
			<div class="pseudo">
				<div class="pseudo_ivo"> • '.$post->itotal.' Pts •<br />'.$pseudo.'
				</div>
			</div>
</div>
<div class="box_forum_avatar_middle_'.$affiche_topic.'">'.$avatar.''.$avatar_link.'
		</div>
<div class="box_forum_avatar_bottom_'.$affiche_topic.'">';

echo '	
<a href="index.php?comp=team">
<img src="./templates/'.$link_style.'/ico/group_'.$pseudoGroup.'.png" onmouseover="Tip(\''.$pseudoGroupInfo.'\')" onmouseout="UnTip()" alt="Groupe"/>
</a>
</div>
	</div>

<div id="pid'.$post->pid.'" class="blockPost">
	<div class="blockPostHeader">
				<i>'.format_time($post->post_time).'</i>
	</div>

	<div class="blockPostContent">
	'.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($post->body))));
	
	if(!empty($post->e_uid)){
		echo '<div class="blockPostEdit">
	Modifié par <a href="index.php?comp=profil&amp;select='.$post->e_uid.'">'.stripslashes(htmlspecialchars($post->e_name)).'</a> le '.format_time($post->post_last_edit_time).'
	</div>';
	}
	echo '
	</div></div>
	<div class="blockPostFooter">&nbsp;<p>'.stripslashes(htmlspecialchars($post->p_signature)).'</p>&nbsp;</div>
	<div align="right" style="padding-bottom: 10px;">		
		<div align="left" style="margin-left: 50px;">
			<a href="#top"><img src="./templates/'.$link_style.'/ico/topic_up.gif" title="Haut de page" height="20px" width="20px" align="top"></a>&nbsp;
			<a href="#bot"><img src="./templates/'.$link_style.'/ico/topic_down.gif" title="Bas de page" height="20px" width="20px" align="top"></a>
		</div>
		<div align="right" style="margin-right: 50px;">'.$moderationPostBar.'</div>
	</div>

</div><div class="topic_bottom_'.$affiche_topic.'"></div>
';	
}
	}

	//Pagination
	displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=forum_topic&amp;select=".$select."&amp;start=", 30);
	echo '<a href="#top">Haut de page</a>';

echo '</form>';
}else{
	echo "Le message que vous essayez de consulter n'existe pas, ou bien vous n'avez pas l'autorisation de le visualiser.";
}
echo '<br /><br />';

//Affichage de la barre d'actions
echo $barreActions;

require_once('./templates/'.$link_style.'bottom.php');

?>


