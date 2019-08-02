<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_FORUM_BOARD
define( '_VALID_CORE_FORUM_BOARD', 1 );

$select = intval($_GET['select']);
$start = intval($_GET['start']);
$filter = intval($_GET['filter']);
$filteraction = $_GET['filteraction'];

if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$select.'_READ')!=TRUE){
	$msg = message::getInstance('ERROR', 'Droits insuffisants pour accéder à ce forum.', './index.php?comp=forum_index');
}

if(!is_array($_SESSION['ForumFilterArray']) || $_SESSION['ForumFilterBoard'] != $select){
	//Nouveau
	$_SESSION['ForumFilterArray'] = array();	$_SESSION['ForumFilterBoard'] = $select;
}


if(!empty($filter) && ($filteraction=='add' || $filteraction=='remove')){
	
	if($filteraction=='add' && in_array($filter, $_SESSION['ForumFilterArray'])===FALSE){
		array_push($_SESSION['ForumFilterArray'],$filter);
	}
	elseif($filteraction=='remove'){
		foreach($_SESSION['ForumFilterArray'] as $key => $value){
			if($value==$filter) unset($_SESSION['ForumFilterArray'][$key]);
		}
	}
}

if(!empty($_SESSION['ForumFilterArray'])){
	$queryFilter = '';
	$queryFilterNb = 0;
	foreach($_SESSION['ForumFilterArray'] as $key => $value){
		if($queryFilter!='') $queryFilter .= ', ';
		$queryFilter .= $value;
		$queryFilterNb++;
	}
	if($queryFilterNb>0){
		$queryFilterFull = "INNER JOIN (
		SELECT topic
		FROM exo_forum_tag_assoc
		WHERE tag IN($queryFilter)
		GROUP BY topic HAVING COUNT(*)=$queryFilterNb
	) topicTag ON topicTag.topic = ft.tid";
	}
}
else{	
	$queryFilter = '';
}


$q = "
	SELECT
		ft.tid,
		ft.subject,
		ft.type,
		ft.nb_replies,
		ft.nb_views,
		ft.locked,
		uf.uid as s_uid,
		uf.pseudo as s_name,
		bf.name as s_bg_name,
		bf.guid as s_bg_guid,
		fpf.post_time as s_time,
		ul.uid as m_uid,
		ul.pseudo as m_name,
		bl.name as m_bg_name,
		bl.guid as m_bg_guid,
		fpl.pid as m_pid,
		fpl.post_time as m_time,
		lf.last_pid as m_last_read,
		fb.board_name,
		fb.nb_topics,
		fc.cat_name,
		fc.catid,
		fc.cat_rp,
		ts.tag,
		CAST(GROUP_CONCAT(DISTINCT CONCAT_WS('|', ts.tag, ta.title) SEPARATOR ';') AS CHAR) AS listeTags
	FROM exo_forum_topics ft
	LEFT JOIN exo_forum_posts fpf ON fpf.pid = ft.first_post_id
	LEFT JOIN exo_users uf ON uf.uid = fpf.author
	LEFT JOIN exo_backgrounds bf ON bf.guid=fpf.author_2
	LEFT JOIN exo_forum_posts fpl ON fpl.pid = ft.last_post_id
	LEFT JOIN exo_users ul ON ul.uid = fpl.author
	LEFT JOIN exo_backgrounds bl ON bl.guid=fpl.author_2
	LEFT JOIN exo_lu_forum lf ON lf.tid = ft.tid AND lf.uid = ".$_SESSION['uid']."
	LEFT JOIN exo_forum_boards fb ON fb.bid = ft.bid
	LEFT JOIN exo_forum_categories fc ON fc.catid = fb.catid
	$queryFilterFull
	LEFT JOIN exo_forum_tag_assoc ts ON ts.topic = ft.tid
	LEFT JOIN exo_forum_tags ta ON ta.tag_id = ts.tag
	WHERE ft.bid = $select AND ft.type !=9
	GROUP BY ft.tid
	ORDER BY ft.type DESC, fpl.post_time DESC
	LIMIT $start,$Nmax";

$rq = $db->Send_Query($q);

$topics = $db->loadObjectList($rq);

$Ntotal = $topics[0]->nb_topics;

//List Tags
$rq = $db->Send_Query("SELECT tag_id, title, description FROM exo_forum_tags WHERE link_bid='$select' ORDER BY title");
$tags = $db->loadObjectList($rq);

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'forum';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Forum' => 'index.php?comp=forum_index',
stripslashes(htmlspecialchars($topics[0]->cat_name)) => 'index.php?comp=forum_index#cat'.intval($topics[0]->catid),
stripslashes(htmlspecialchars($topics[0]->board_name)) => ''
); 
$ws_name_perso = 'Evoxis v5 - Forum - '.stripslashes(htmlspecialchars($topics[0]->board_name)).'';
?>


