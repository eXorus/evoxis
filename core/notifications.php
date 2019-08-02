<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_NOTIFICATIONS', 1 );

if(!empty($_GET['vote'])){
	$voteid = intval($_GET['vote']);
	$uid = intval($_SESSION['uid']);
	$vnow = time();

	$vq = $db->Send_Query("
		SELECT vclink
		FROM exo_vote 
		LEFT JOIN exo_vote_config ON vcid=v_vcid 
		WHERE v_vcid=$voteid AND vuid=$uid AND vlastvote<=$vnow-vctime");
		
	if ($db->num_rows($vq)==1){
		//déjà voté et peut revoter
		$rq = $db->Send_Query("UPDATE exo_vote SET vlastvote=$vnow, vcompteur=vcompteur+1 WHERE v_vcid=$voteid AND vuid=$uid");
		
		$result = $db->get_array($vq);
		$link = $result['vclink'];
		
		$msg = message::getInstance('N/A','N/A', $link);
	}
	else{
		//pas encore voté mais peut voter peut etre
		$vq = $db->Send_Query("
			SELECT v_vcid 
			FROM exo_vote 
			LEFT JOIN exo_vote_config ON vcid=v_vcid 
			WHERE v_vcid=$voteid AND vuid=$uid");
		if ($db->num_rows($vq)==1){
			//Ne peut pas voter
			$msg = message::getInstance('ERROR','Vous ne pouvez plus voter', 'index.php?comp=last_read');
		}
		else{
			//Premier vote du mois
			$rq = $db->Send_Query("INSERT INTO exo_vote (v_vcid, vuid, vlastvote, vcompteur) VALUES ($voteid, $uid, 0, 0)");
			$msg = message::getInstance('SUCCES','Vote pris en compte', 'index.php?comp=last_read&amp;vote='.$voteid);
		}
	}
	
}

if(!empty($_GET['task']) && $_GET['task']=='mark' && !empty($_GET['select'])){
	
	$time_lu = time();
	
	if($_GET['select']=='forum'){	
		$rq = $db->Send_Query("
			UPDATE exo_users 
			SET 	lu_date_forum='$time_lu'
			WHERE uid='".intval($_SESSION['uid'])."'");	
		$_SESSION['lu_date_forum'] = $time_lu;	
		
	}
	else if($_GET['select']=='news'){
		$query_news = "
			SELECT l.uid, n.title, n.nid, l.last_cid, n.last_commentaire_id
			FROM exo_news n
			LEFT JOIN exo_lu_news l ON (n.nid = l.nid AND l.uid='".$_SESSION['uid']."')
			WHERE 
			n.last_commentaire_id > l.last_cid
			OR
			l.uid IS NULL"; 
		$rq_news = $db->Send_Query($query_news);
		$news = $db->loadObjectList($rq_news);
		
		foreach($news as $new){
			if(empty($new->uid)){
				//Jamais Lu				
				$query_insert = "INSERT INTO exo_lu_news(uid,nid,last_cid) 
								VALUES (".$_SESSION['uid'].",".$new->nid.",".$new->last_commentaire_id.")";
				$rq_insert = $db->Send_Query($query_insert);
			}
			else{
				//Déjà Lu			
				$query_update = "UPDATE exo_lu_news SET last_cid=".$new->last_commentaire_id." WHERE uid=".$_SESSION['uid']." AND nid=".$new->nid."";
				$rq_update = $db->Send_Query($query_update);
			}
		}
	}
	else if($_GET['select']=='bugs'){
		$rq = $db->Send_Query("
			UPDATE exo_users 
			SET 	lu_date_bugtracker='$time_lu'
			WHERE uid='".intval($_SESSION['uid'])."'");	
		$_SESSION['lu_date_bugtracker'] = $time_lu;	
	}
	$msg = message::getInstance('WARNING','Votre demande ne peut pas être prise en compte', 'index.php?comp=last_read');
}


//Vérification de tous les votes
$vnow = time();
$uid = intval($_SESSION['uid']);

$vq = $db->Send_Query("
	SELECT vcid, vcimg
	FROM exo_vote_config
	LEFT JOIN exo_vote ON vcid=v_vcid AND vuid=$uid
	WHERE vlastvote<=$vnow-vctime OR vuid IS NULL");
	
if ($db->num_rows($vq)>0){
	$voteaf = $db->loadObjectList($vq);
	
	if(!empty($voteaf)){
		foreach($voteaf as $v){
			$printVote .= '<center><a href="./index.php?comp=notifications&amp;vote='.$v->vcid.'" target="_blank">
			<img src="./templates/default/pic/'.$v->vcimg.'"alt="Votez !"/></a></center><br />';
		}
	}
}


	//###
	//MP
	//###	
	$query_mp = "
		SELECT D.dpID as id, D.dpTitle as title, M.mpDateCreation as date, P.last_msg_vu as last_id
		FROM exo_mp_discussions D
		INNER JOIN exo_mp_participate P ON P.dpID=D.dpID AND P.uid=".$_SESSION['uid']." AND participe=1
		INNER JOIN exo_mp_messages M ON M.mpID=D.last_mpID
		WHERE P.last_msg_vu<D.last_mpID
		ORDER BY M.mpID DESC";
				
	$result_mp = $db->Send_Query($query_mp);
	$notifMPS = $db->loadObjectList($result_mp);


	//###
	//NEWS
	//###
	$query_news = "
				SELECT t.tid as id, t.subject as title, l.last_pid
				FROM exo_forum_topics t
				LEFT JOIN exo_lu_forum l ON (t.tid = l.tid AND l.uid='".$_SESSION['uid']."')
				LEFT JOIN exo_forum_boards b ON b.bid = t.bid AND b.bid=".FORUM_NEWS."
				LEFT JOIN exo_forum_posts p ON p.pid = t.last_post_id
				WHERE 
				(t.last_post_id > l.last_pid
				OR
				l.uid IS NULL)
				AND
				p.post_time > '".intval($_SESSION['lu_date_forum'])."'
				ORDER BY c.disp_position"; 
	$rq_news = $db->Send_Query($query_news);
	$notifNEWS = $db->loadObjectList($rq_news);

	//###
	//FORUM
	//###
	$query_forums = "
				SELECT l.uid, t.subject, t.tid, l.last_pid, c.cat_name
				FROM exo_forum_topics t
				LEFT JOIN exo_lu_forum l ON (t.tid = l.tid AND l.uid='".$_SESSION['uid']."')
				LEFT JOIN exo_forum_boards b ON b.bid = t.bid
				LEFT JOIN exo_forum_posts p ON p.pid = t.last_post_id
				LEFT JOIN exo_forum_categories c ON c.catid = b.catid
				WHERE 
				b.bid != ".FORUM_NEWS."
				AND
				(t.last_post_id > l.last_pid
				OR
				l.uid IS NULL)
				AND
				p.post_time > '".intval($_SESSION['lu_date_forum'])."'
				ORDER BY c.disp_position"; 
	$rq_forums = $db->Send_Query($query_forums);
	$notifFORUMS = $db->loadObjectList($rq_forums);


	//###
	//BUGTRACKER
	//###
	$query_bugtrackers = "
				SELECT l.uid, b.bt_name, b.btid, l.last_btcid
				FROM exo_bugtracker b
				LEFT JOIN exo_lu_bugtracker l ON (b.btid = l.btid AND l.uid='".$_SESSION['uid']."')
				LEFT JOIN exo_bugtracker_commentaires bc ON bc.btcid=l.last_btcid
				WHERE 
				(b.last_commentaire_id > l.last_btcid AND bc.time_create > '".intval($_SESSION['lu_date_bugtracker'])."')
				OR
				(l.uid IS NULL AND b.bt_time_create > '".intval($_SESSION['lu_date_bugtracker'])."')
				ORDER BY b.btid, l.last_btcid DESC
				LIMIT 0, 10"; 
	$rq_bugtrackers = $db->Send_Query($query_bugtrackers);
	$notifBUGTRACKERS = $db->loadObjectList($rq_bugtrackers);

/*
* MANAGE PATHWAY
*/
$pathway = array(
'Notifications' => ''
);
$ws_name_perso = 'Evoxis v5 - Notifications';
?>
