<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_TEAM
define( '_VALID_CORE_TEAM', 1 );

$rq = $db->Send_Query("
			SELECT u.uid, u.wow_id, u.username, u.pseudo, u.last_date_connect, gp.name, GM.gmID, GM.gmName, GM.gmDesc, OJ.objectif, P.id as avatarID, P.image_extension as avatarExtID, w.online_time, A.online
			FROM exo_users u
			LEFT JOIN exo_groups_users g ON g.uid = u.uid
			LEFT JOIN exo_security_assign ass ON ((ass.ass_Type='G' AND ass.ass_cible = g.gid) OR (ass.ass_Type='U' AND ass.ass_cible = u.uid) )
			LEFT JOIN exo_security_ACL acl ON acl.acl_ID = ass.ass_ACL
			LEFT JOIN exo_groups gp ON gp.gid = g.gid
			LEFT JOIN exo_groups_master GM on GM.gmID=gp.gmID
			LEFT JOIN exo_groups_objectifs OJ ON OJ.uid = u.uid
			LEFT JOIN exo_pictures P ON (P.uid = u.uid AND P.type=1 AND P.selected=1)
			LEFT JOIN exo_whoisonline w ON w.online_id = u.uid
			LEFT JOIN $db_name_realmd.account A ON A.id =u.wow_id
			WHERE acl.acl_Key='FO_TEAM'
			GROUP BY uid
			ORDER BY gp.access_Level DESC, gp.name");
$mjs_actifs = $db->loadObjectList($rq);

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'equipe';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Equipe' => ''
);
$ws_name_perso = 'Evoxis v5 - Equipe';
?>
