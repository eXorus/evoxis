<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_MEMBRES
define( '_VALID_CORE_MEMBRES', 1 );




if(!empty($_GET['task']) && $_GET['task']=='ig'){
	
	require_once("./inc/function/wow.php");
	
	// ## IG ##
	if(!empty($_GET['sort'])){

		$tab_sort = explode(";",$_GET['sort']);
		
		if (!empty($tab_sort[0]) && ($tab_sort[1]=='DESC' || $tab_sort[1]=='ASC')){
		
			if($tab_sort[0]=='nom') $order_by = "ORDER BY c.name ".$tab_sort[1];
			elseif($tab_sort[0]=='race') $order_by = "ORDER BY c.race ".$tab_sort[1];
			elseif($tab_sort[0]=='class') $order_by = "ORDER BY c.class ".$tab_sort[1];
			elseif($tab_sort[0]=='time') $order_by = "ORDER BY c.totaltime ".$tab_sort[1];
			elseif($tab_sort[0]=='level') $order_by = "ORDER BY level ".$tab_sort[1];
			else $order_by = "ORDER BY c.name";
		}
		else $order_by = "ORDER BY c.name";	
	}
	else $order_by = "ORDER BY c.name";
	
	$rq = $db_characters->Send_Query("
				SELECT c.guid, c.name, c.race, c.class, c.totaltime, c.extra_flags, c.map, c.position_x, c.position_y, CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', $playerDataFieldLevel), ' ', -1) AS UNSIGNED) AS `level`, mid(lpad( hex( CAST(substring_index(substring_index(data,' ', $playerDataFieldGender),' ',-1) as unsigned) ),8,'0'),4,1) as sex
				FROM `characters` c
				WHERE online=1
				$order_by");
	$membres = $db_characters->loadObjectList($rq);
	
/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'ingame';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Joueurs en ligne' => ''
);
$ws_name_perso = 'Evoxis v5 - Joueurs en ligne';
}
else{
	// ## SITE ##
	$start = intval($_GET['start']);
	
	if($_GET['task']=='actif'){
		$limit = time() - (15*24*60*60);
		$clauseFrom = "	FROM evoxis.exo_users u
						LEFT JOIN exo_indices i ON i.uid = u.uid
						LEFT JOIN exo_whoisonline w ON w.online_id = u.uid
						LEFT JOIN $db_name_realmd.`account` r ON r.id=u.wow_id";
		$clauseWhere = "WHERE 
						u.last_date_connect>".$limit."
						AND
						TO_DAYS( NOW( ) ) - TO_DAYS( r.last_login ) <=15";
	}
	else{
		$clauseFrom = "	FROM exo_users u
						LEFT JOIN exo_indices i ON i.uid = u.uid
						LEFT JOIN exo_whoisonline w ON w.online_id = u.uid";
		$clauseWhere = "";
	}

	if(!empty($_GET['sort'])){

		$tab_sort = explode(";",$_GET['sort']);
		
		if (!empty($tab_sort[0]) && ($tab_sort[1]=='DESC' || $tab_sort[1]=='ASC')){
		
			if($tab_sort[0]=='login'){
				$order_by = "ORDER BY u.username ".$tab_sort[1];
				$link_sort = "&amp;sort=login;".$tab_sort[1];
			}
			elseif($tab_sort[0]=='pseudo'){
				$order_by = "ORDER BY u.pseudo ".$tab_sort[1];
				$link_sort = "&amp;sort=pseudo;".$tab_sort[1];
			}
			elseif($tab_sort[0]=='ivo'){
				$order_by = "ORDER BY i.total ".$tab_sort[1];
				$link_sort = "&amp;sort=ivo;".$tab_sort[1];
			}
			elseif($tab_sort[0]=='site'){
				$order_by = "ORDER BY w.online_time ".$tab_sort[1];
				$link_sort = "&amp;sort=site;".$tab_sort[1];
			}
			else $order_by = "ORDER BY u.username";
		}
		else $order_by = "ORDER BY u.username";	
	}
	else $order_by = "ORDER BY u.username";

	$rq = $db->Send_Query("
				SELECT u.uid, u.wow_id, u.username, u.pseudo, i.total, w.online_time
				$clauseFrom
				$clauseWhere
				$order_by
				LIMIT $start,$Nmax");
	$membres = $db->loadObjectList($rq);

	$rq_wow = $db_realmd->Send_Query("SELECT id,online FROM account");
	$tab_online_wow = array();
	while ($wow = $db_realmd->get_array($rq_wow)){
		$tab_online_wow[$wow['id']] = $wow['online'];
	}


	$result = $db->Send_Query("SELECT COUNT(*) FROM exo_users");
	$ligne = $db->get_row($result);
	$Ntotal = $ligne[0];
	
	/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'membres';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Membres' => 'index.php?comp=membres',
'Liste des membres' => ''
);
$ws_name_perso = 'Evoxis v5 - Membres';
}
	

?>
