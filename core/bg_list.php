<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_BG
define( '_VALID_CORE_BG_LIST', 1 );


if(!empty($_GET['task']) && $_GET['task']=='vote' && !empty($_POST['note']) && !empty($_GET['guid']) && !empty($_SESSION['uid'])){
	$note = intval($_POST['note']);
	$guid = intval($_GET['guid']);
	
	//GUID existe?
	$result = $db->Send_Query("SELECT COUNT(*) FROM exo_backgrounds WHERE guid='$guid' AND wow_id!='".$_SESSION['wow_id']."'");
	$ligne = $db->get_row($result);
	$guid_existe = $ligne[0];
	
	
	if($note>0 && $note <6 && $guid_existe==1){
	
		//Déja voté?
		$result = $db->Send_Query("SELECT COUNT(*) FROM exo_backgrounds_vote WHERE guid='$guid' AND uid='".intval($_SESSION['uid'])."'");
		$ligne = $db->get_row($result);
		$vote_existe = $ligne[0];
		
		
		if($vote_existe==1){
			//Déjà Voté je modifie mon vote
			$result = $db->Send_Query("UPDATE exo_backgrounds_vote 
			SET note='$note', time='".time()."' 
			WHERE uid='".intval($_SESSION['uid'])."' AND guid='$guid'");
			
			//Spyvo
			$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'BG', 'Edit vote;GUID='.$guid.';Note='.$note);
			
			$msg = message::getInstance('SUCCESS','La modification de votre vote a été prise en compte', 'index.php?comp=bg_list');
		}
		else{
			//Jamais voté je vote
			$result = $db->Send_Query("INSERT INTO exo_backgrounds_vote (uid, guid, note, time)
			VALUES('".intval($_SESSION['uid'])."', '$guid', '$note', '".time()."')");
			
			$rq = $db->Send_Query("
				SELECT u.uid 
				FROM exo_users u, exo_backgrounds b 
				WHERE b.wow_id= u.wow_id 
				AND b.guid='$guid'");
			$ind = $db->get_array($rq);	
			$uid = $ind['uid'];
			
			//Ivo
			update_ivo('nb_bg_vote', $uid, $note);
			
			//Spyvo
			$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'BG', 'Vote;GUID='.$guid.';Note='.$note);
			
			$msg = message::getInstance('SUCCESS','Votre vote a été pris en compte', 'index.php?comp=bg_list');
		}
	}
	$msg = message::getInstance('ERROR','Vote incorrect', 'index.php?comp=bg_list');
}



$start = intval($_GET['start']);

if(!empty($_GET['sort'])){

	$tab_sort = explode(";",$_GET['sort']);
		
	if (!empty($tab_sort[0]) && ($tab_sort[1]=='DESC' || $tab_sort[1]=='ASC')){
		
		if($tab_sort[0]=='name'){
			$order_by = "ORDER BY b.name ".$tab_sort[1];
			$link_sort = "&amp;sort=name;".$tab_sort[1];
		}
		elseif($tab_sort[0]=='race'){
			$order_by = "ORDER BY b.race ".$tab_sort[1];
			$link_sort = "&amp;sort=race;".$tab_sort[1];
		}
		elseif($tab_sort[0]=='class'){
			$order_by = "ORDER BY b.class ".$tab_sort[1];
			$link_sort = "&amp;sort=class;".$tab_sort[1];
		}
		elseif($tab_sort[0]=='creation_time'){
			$order_by = "ORDER BY b.creation_time ".$tab_sort[1];
			$link_sort = "&amp;sort=creation_time;".$tab_sort[1];
		}
		elseif($tab_sort[0]=='last_edit_time'){
			$order_by = "ORDER BY b.last_edit_time ".$tab_sort[1];
			$link_sort = "&amp;sort=last_edit_time;".$tab_sort[1];
		}
		elseif($tab_sort[0]=='statut'){
			$order_by = "ORDER BY b.statut ".$tab_sort[1];
			$link_sort = "&amp;sort=statut;".$tab_sort[1];
		}
		elseif($tab_sort[0]=='vote'){
			$order_by = "ORDER BY nb_vote ".$tab_sort[1];
			$link_sort = "&amp;sort=vote;".$tab_sort[1];
		}
		else $order_by = "ORDER BY nb_vote DESC";
	}
	else $order_by = "ORDER BY nb_vote DESC";	
}
else $order_by = "ORDER BY nb_vote DESC";

//Récupération de tous les persos
$limit = time() - (15*24*60*60);
$query = "	SELECT b.guid, b.name, b.race, b.class, b.creation_time, b.last_edit_time, b.statut, AVG(v.note) as nb_vote, v2.note as vote
			FROM exo_backgrounds b
			LEFT JOIN exo_backgrounds_vote v ON v.guid = b.guid
			LEFT JOIN exo_backgrounds_vote v2 ON (v2.guid = b.guid AND v2.uid='".intval($_SESSION['uid'])."')
			LEFT JOIN exo_users u ON u.wow_id=b.wow_id
			LEFT JOIN $db_name_realmd.`account` r ON r.id=u.wow_id
			WHERE b.statut='VALIDE' AND (
											u.last_date_connect>".$limit."
											AND
											TO_DAYS( NOW( ) ) - TO_DAYS( r.last_login ) <=15
										) 
			GROUP BY b.guid
			$order_by
			LIMIT $start,$Nmax";
$result = $db->Send_Query($query);
$backgrounds = $db->loadObjectList($result);

$result = $db->Send_Query("SELECT COUNT(*) FROM exo_backgrounds b			
			LEFT JOIN exo_users u ON u.wow_id=b.wow_id
			LEFT JOIN $db_name_realmd.`account` r ON r.id=u.wow_id
			WHERE b.statut='VALIDE' AND (
											u.last_date_connect>".$limit."
											AND
											TO_DAYS( NOW( ) ) - TO_DAYS( r.last_login ) <=15
										) ");
$ligne = $db->get_row($result);
$Ntotal = $ligne[0];

//Favourite
$query = "	SELECT b.guid, b.name, u.pseudo as mj, favourite_date, favourite_by
			FROM exo_backgrounds b
			LEFT JOIN exo_users u ON u.uid=b.favourite_by
			WHERE favourite_date != 0
			GROUP BY b.guid
			ORDER BY favourite_date DESC
			LIMIT 4";
$result = $db->Send_Query($query);
$background_fav = $db->loadObjectList($result);

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'backgrounds';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Backgrounds' => ''
);
$ws_name_perso = 'Evoxis v5 - Backgrounds';
?>