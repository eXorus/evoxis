<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_NEWS
define( '_VALID_CORE_NEWS', 1 );

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
		fpf.post_time as s_time,
		fpf.post_last_edit_time,
		fpf.post_last_edit_uid,
		ul.uid as m_uid,
		ul.pseudo as m_name,
		fpl.pid as m_pid,
		fpl.post_time as m_time,
		fpf.body,
		fb.board_name,
		fb.nb_topics,
		fc.cat_name,
		fc.catid,
		ts.tag,
		CAST(GROUP_CONCAT(DISTINCT CONCAT_WS('|', ts.tag, ta.title) SEPARATOR ';') AS CHAR) AS listeTags
	FROM exo_forum_topics ft
	LEFT JOIN exo_forum_posts fpf ON fpf.pid = ft.first_post_id
	LEFT JOIN exo_users uf ON uf.uid = fpf.author
	LEFT JOIN exo_forum_posts fpl ON fpl.pid = ft.last_post_id
	LEFT JOIN exo_users ul ON ul.uid = fpl.author
	LEFT JOIN exo_forum_boards fb ON fb.bid = ft.bid
	LEFT JOIN exo_forum_categories fc ON fc.catid = fb.catid
	LEFT JOIN exo_forum_tag_assoc ts ON ts.topic = ft.tid
	LEFT JOIN exo_forum_tags ta ON ta.tag_id = ts.tag
	LEFT JOIN exo_config CFG ON CFG.conf_key='FORUM_NEWS'
	WHERE ft.bid = CFG.conf_value AND ft.type !=9
	GROUP BY ft.tid
	ORDER BY ft.type DESC, fpl.post_time DESC
	LIMIT 0, 10";

$rq = $db->Send_Query($q);

$topics = $db->loadObjectList($rq);

	
/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'news';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'News' => 'index.php?comp=news',
'Dernières News' => ''
);
$ws_name_perso = 'Evoxis v5 - News';
?>
