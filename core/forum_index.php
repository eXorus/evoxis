<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_FORUM_INDEX
define( '_VALID_CORE_FORUM_INDEX', 1 );

$rq = $db->Send_Query("
		SELECT 
			fb.catid,
			fc.cat_name,
			fc.cat_rp,			
			fb.bid, 
			fb.board_name, 
			fb.board_description, 
			fb.nb_topics, 
			fb.nb_posts, 
			fp.pid,
			fp.post_time,
			fp.tid,
			u.pseudo,
			b.name,
			b.guid,
			u.uid,
			ft.subject,
			GROUP_CONCAT(DISTINCT CONCAT(ta.tag_id,'|',ta.title) SEPARATOR ';') as tags
		FROM exo_forum_categories fc
		LEFT JOIN exo_forum_boards fb ON fb.catid = fc.catid
		LEFT JOIN exo_forum_posts fp ON fp.pid = fb.last_post_id
		LEFT JOIN exo_users u ON u.uid = fp.author
		LEFT JOIN exo_backgrounds b ON b.guid = fp.author_2
		LEFT JOIN exo_forum_topics ft ON ft.tid = fp.tid
		LEFT JOIN exo_forum_tags ta ON ta.link_bid = fb.bid
		GROUP BY fb.bid
		ORDER BY fc.disp_position, fb.disp_position");
$boards = $db->loadObjectList($rq);

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'forum';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Forum' => ''
); 
$ws_name_perso = "Evoxis v5 - Forum";
?>
