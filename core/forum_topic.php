<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_FORUM_TOPIC', 1 );


if(!empty($_GET['task']) && $_GET['task']="process" && !empty($_POST['pID'])){
	
	$error = 0;
	//Vote
	$pID = intval($_POST['pID']);
	
	$rq = $db->Send_Query("
	SELECT PO.pID, PO.pLink, PO.pAgain, PO.pNbDays, P.post_time, pqID, pqTitle, pqMaxReponse, CAST( GROUP_CONCAT( DISTINCT paPCID SEPARATOR ';' ) AS CHAR ) AS answers
	FROM exo_poll PO
	LEFT JOIN exo_poll_questions ON pqLink = PO.pID
	LEFT JOIN exo_poll_choice ON pcLink = pqID
	LEFT JOIN exo_poll_answer ON paPCID=pcID AND paUID=".$_SESSION['uid']."	
	LEFT JOIN exo_forum_topics ON tid=pLink
	LEFT JOIN exo_forum_posts P ON P.pid=first_post_id
	WHERE PO.pID = $pID
	GROUP BY pqID");
	$polls = $db->loadObjectList($rq);
	
	if(!empty($polls[0]->pNbDays) && $polls[0]->post_time+$polls[0]->pNbDays*24*3600<time()){
		$msg = message::getInstance('ERROR','Ce sondage est clos, vous ne pouvez plus voter', 'index.php?comp=forum_topic&select='.$polls[0]->pLink.'&start=0');
		exit();
	}
	
	$row = $db->get_array($db->Send_Query("
		SELECT COUNT(paUID) as nbr_vote
	FROM exo_poll
	LEFT JOIN exo_poll_questions ON pqLink = pID
	LEFT JOIN exo_poll_choice ON pcLink = pqID
	LEFT JOIN exo_poll_answer ON paPCID=pcID AND paUID=".$_SESSION['uid']."
	WHERE pID = $pID AND paUID IS NOT NULL
	GROUP BY paUID"));
	$nbr_vote = $row['nbr_vote'];
	
	if($nbr_vote>0 && $polls[0]->pAgain==0){
		$msg = message::getInstance('ERROR','Ce sondage ne permet pas de changer son vote', 'index.php?comp=forum_topic&select='.$polls[0]->pLink.'&start=0');
		exit();
	}
	
	foreach($polls as $poll){
		if($poll->pqMaxReponse==1){
			//Réponse unique - Bouton Radio
			$newChoix = intval($_POST['pollChoiceRadio_'.$poll->pqID]);
			if(!empty($poll->answers)){
				//déjà voté
				if($poll->answers != $newChoix){
					$r = $db->Send_Query("UPDATE exo_poll_answer SET paPCID=$newChoix, paDate=NOW() WHERE paUID=".$_SESSION['uid']." AND paPCID=".$poll->answers);
				}
			}
			else{
				//premier vote
				$r = $db->Send_Query("INSERT INTO exo_poll_answer(paUID, paPCID, paDate) VALUES(".$_SESSION['uid'].", $newChoix, NOW())");
			}
		}
		else{
			//Réponse multiples - Checkbox
			$answers = explode(";",$poll->answers);
			
			$nbReponses = count($answers);
			$nbReponsesMax = $poll->pqMaxReponse;
			
			foreach($answers as $answer){
				if($_POST['pollChoiceCheckbox_'.$poll->pqID.'_'.$answer]!="on"){
					//Ancien vote a changer
					$r = $db->Send_Query("DELETE FROM exo_poll_answer WHERE paUID=".$_SESSION['uid']." AND paPCID=$answer");
					$nbReponses--;
				}
			}
			
			//On rajoute
			foreach($_POST as $key => $value){
				if(substr_count($key, "pollChoiceCheckbox_".$poll->pqID."_")==1 && $value=="on"){
					//A ajouter si il n'existe pas deja
					$newChoix = str_replace("pollChoiceCheckbox_".$poll->pqID."_", "", $key);
							
					if (!in_array($newChoix, $answers)) {
						if($nbReponses < $nbReponsesMax){
							$r = $db->Send_Query("INSERT INTO exo_poll_answer(paUID, paPCID, paDate) VALUES(".$_SESSION['uid'].", $newChoix, NOW())");
							$nbReponses++;
						}
						else{
							$error++;
						}
					}			
					
				}
			}
		}
	}
	
	if(empty($error)) $msg = message::getInstance('SUCCESS','Envoie du sondage réussie', 'index.php?comp=forum_topic&select='.$polls[0]->pLink.'&start=0');
	else  $msg = message::getInstance('WARNING','Des erreurs ont été rencontrées durant la validation de votre sondage', 'index.php?comp=forum_topic&select='.$polls[0]->pLink.'&start=0');
}
	
$select = intval($_GET['select']);
$start = intval($_GET['start']);
$goto = intval($_GET['goto']);

if(empty($start) && !empty($goto)){
	//Je connais pas la page mais j'ai l'id du post
	$result = $db->Send_Query("SELECT COUNT(*) FROM exo_forum_posts WHERE pid <= '$goto' AND tid='$select'");
	$go = $db->get_row($result);
	$num_before = $go[0];
	$page = ceil($num_before/$Nmax);
	$start = (($page-1)*$Nmax);	
}


$rq = $db->Send_Query("
	SELECT 
		fp.pid,
		fp.body,
		up.pseudo as p_name,
		up.uid as p_uid,
		b.guid as bg_guid,
		b.name as bg_name,
		up.wow_id as p_wow_id,
		up.username,
		up.sexe,
		ep.id as avatarID,
		ep.image_extension as avatarExtID,
		ep_2.id as bg_img_id,
		ep_2.image_extension as bg_img_ext,
		up.signature as p_signature,
		fp.post_time,
		fp.post_last_edit_time,
		ue.pseudo as e_name,
		ue.uid as e_uid,
		i.total as itotal,
		ft.subject as topic_subject,
		fb.board_name as board_name,
		fb.bid as board_id,
		ft.nb_replies as nb_posts,
		ft.last_post_id,
		ft.first_post_id,
		ft.tid,
		ft.locked,
		fc.cat_name,
		fc.catid,
		fc.cat_rp,
		g.gid,
		CAST(GROUP_CONCAT(DISTINCT CONCAT_WS('|', ts.tag, ta.title) SEPARATOR ';') AS CHAR) AS listeTags,
		pAgain,
		pNbDays,
		m.type as messageType,
		m.message as messageBody,
		um.pseudo as messageAuthor,
		m.date as messageDate		
	FROM exo_forum_posts fp
	LEFT JOIN exo_users up ON up.uid = fp.author
	LEFT JOIN exo_backgrounds b ON b.guid = fp.author_2
	LEFT JOIN exo_users ue ON ue.uid = fp.post_last_edit_uid
	LEFT JOIN exo_indices i ON i.uid = fp.author
	LEFT JOIN exo_forum_topics ft ON ft.tid = fp.tid
	LEFT JOIN exo_forum_boards fb ON fb.bid = ft.bid
	LEFT JOIN exo_forum_categories fc ON fc.catid = fb.catid
	LEFT JOIN exo_pictures ep ON (ep.uid = fp.author AND ep.type=1 AND ep.selected=1)
	LEFT JOIN exo_pictures ep_2 ON ep_2.id=b.imgID AND ep_2.type=4
	LEFT JOIN exo_groups_users gu ON gu.uid=fp.author
	LEFT JOIN exo_groups g ON g.gid=gu.gid
	LEFT JOIN exo_forum_tag_assoc ts ON ts.topic = ft.tid
	LEFT JOIN exo_forum_tags ta ON ta.tag_id = ts.tag
	LEFT JOIN exo_poll ON pLink=ft.tid
	LEFT JOIN exo_forum_messages m ON m.mid=fp.pid 
	LEFT JOIN exo_users um ON m.author=um.uid
	WHERE fp.tid = '$select' AND ft.type !=9
	GROUP BY ft.tid, fp.pid HAVING MAX(g.access_Level)
	ORDER BY fp.post_time
	LIMIT $start,$Nmax");

$posts = $db->loadObjectList($rq);

if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$posts[0]->board_id.'_READ')!=TRUE){
	$msg = message::getInstance('ERROR', 'Droits insuffisants pour accéder à ce forum.', './index.php?comp=forum_index');
}

//Sondage
$row = $db->get_array($db->Send_Query("
		SELECT COUNT(paUID) as nbr_vote
	FROM exo_poll
	LEFT JOIN exo_poll_questions ON pqLink = pID
	LEFT JOIN exo_poll_choice ON pcLink = pqID
	LEFT JOIN exo_poll_answer ON paPCID=pcID AND paUID=".$_SESSION['uid']."
	WHERE pLink = $select AND paUID IS NOT NULL
	GROUP BY paUID"));
$nbr_vote = $row['nbr_vote'];


if(  ($nbr_vote==0 || $_GET['mode']=="modifvote")  &&  ($posts[0]->post_time+$posts[0]->pNbDays*24*3600>time() || $posts[0]->pNbDays==0)  ){
	$rq = $db->Send_Query("
		SELECT pID, pAgain, pNbDays, pqID, pqTitle, pqMaxReponse, pcID, pcLink, pcTitle, paDate
		FROM exo_poll
		LEFT JOIN exo_poll_questions ON pqLink = pID
		LEFT JOIN exo_poll_choice ON pcLink = pqID
		LEFT JOIN exo_poll_answer ON paPCID=pcID AND paUID=".$_SESSION['uid']."
		WHERE pLink = $select");
	$polls = $db->loadObjectList($rq);
	
	$printMode = "FORM";
}
else{
	$rq = $db->Send_Query("
		SELECT pID, pAgain, pNbDays, pqID, pqTitle, pcID, pcLink, pcTitle, COUNT(paDate) as nbvote
		FROM exo_poll
		LEFT JOIN exo_poll_questions ON pqLink = pID
		LEFT JOIN exo_poll_choice ON pcLink = pqID
		LEFT JOIN exo_poll_answer ON paPCID=pcID
		WHERE pLink = $select
		GROUP BY pcID");
	$polls = $db->loadObjectList($rq);
	
	$printMode = "RESULT";
}


	
//Update le nb de vue
$query = "UPDATE exo_forum_topics SET nb_views=nb_views+1 WHERE tid = '$select'";
$result = $db->Send_Query($query);

//Nb_replies +1 le post du topic
$Ntotal = $posts[0]->nb_posts+1;



if(!empty($_SESSION['uid'])){
	//Topic déjà consulté ?
	$nbr_vu = $db->get_result($db->Send_Query('
		SELECT uid 
		FROM exo_lu_forum
		WHERE tid = '.$select.' AND uid = '.$_SESSION['uid'].''), 0);
		
	$last_pid = $posts[0]->last_post_id;

		
	if ($nbr_vu == 0) //Si c'est la première fois on insère une ligne entière
	{
		
	    $db->Send_Query('
			INSERT INTO exo_lu_forum (uid, tid, last_pid)
	        VALUES ('.$_SESSION['uid'].', '.$select.','.$last_pid.')');
	}
	else //Sinon on met simplement à jour
	{
	    $db->Send_Query('UPDATE exo_lu_forum SET last_pid =
	        '.$last_pid.' WHERE tid = '.$select.'
	        AND uid = '.$_SESSION['uid'].'');
			
	}
}

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'forum';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Forum' => 'index.php?comp=forum_index',
$posts[0]->cat_name => 'index.php?comp=forum_index#cat'.intval($posts[0]->catid),
$posts[0]->board_name => 'index.php?comp=forum_board&amp;select='.intval($posts[0]->board_id).'&amp;start=0',
$posts[0]->topic_subject => ''
);  
$ws_name_perso = 'Evoxis v5 - Forum - '.$posts[0]->topic_subject.'';
?>
