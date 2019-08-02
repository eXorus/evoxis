<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_GUILDS', 1 );

$_SESSION['BoxStateMsg'] = array ();

if ($_GET['task']=='process_guilds' && !empty($_POST['guildid'])){
	$guildid = intval($_POST['guildid']);
	$comment = mysql_real_escape_string($_POST['comment']);

	if($_POST['result']=='NON_VALIDE' || $_POST['result']=='VALIDE'){
		$query_update = "UPDATE exo_guilds SET statut='".$_POST['result']."' WHERE guildid='$guildid' AND statut='EN_ATTENTE'";
		$result_update = $db->Send_Query($query_update);
		$update = $db->num_rows();
		
		if($update==1){
			//Ajouter le tag public
			$r = $db->Send_Query("INSERT INTO exo_forum_tags (tag_id, link_bid, title, description) 
				SELECT NULL, conf_value, name, name
				FROM exo_guilds
				LEFT JOIN exo_config ON conf_key='FORUM_GUILDS'
				WHERE guildid='$guildid'");
			
			
			//Ajouter le forum privé
			$r = $db->Send_Query("INSERT INTO exo_forum_boards (bid, catid, board_name, board_description, nb_topics, nb_posts, last_post_id, disp_position)
			SELECT NULL, conf_value, name, CONCAT('Forum privé: ',name), 0, 0, 0, (SELECT MAX(disp_position)+1 FROM exo_forum_boards WHERE catid=conf_value GROUP BY catid)
			FROM exo_guilds
			LEFT JOIN exo_config ON conf_key='FORUM_GUILDS_CAT'
			WHERE guildid='$guildid'");
			$bid = $db->last_insert_id();
			
			$rq = $db->Send_Query("INSERT INTO `exo_security_ACL`(acl_ID, acl_Key, acl_Description)
				SELECT NULL, CONCAT('FO_FORUM_BOARD_', bid, '_READ'), CONCAT('Lecture du forum ',board_name)
				FROM exo_forum_boards
				WHERE bid=$bid");
			
			$rq = $db->Send_Query("INSERT INTO `exo_security_ACL`(acl_ID, acl_Key, acl_Description)
				SELECT NULL, CONCAT('FO_FORUM_BOARD_', bid, '_REPLY'), CONCAT('Répondre sur le forum ',board_name)
				FROM exo_forum_boards
				WHERE bid=$bid");
			
			$rq = $db->Send_Query("INSERT INTO `exo_security_ACL`(acl_ID, acl_Key, acl_Description)
				SELECT NULL, CONCAT('FO_FORUM_BOARD_', bid, '_CREATE'), CONCAT('Créer un sujet sur le forum ',board_name)
				FROM exo_forum_boards
				WHERE bid=$bid");
				
			$rq = $db->Send_Query("INSERT INTO `exo_security_ACL`(acl_ID, acl_Key, acl_Description)
				SELECT NULL, CONCAT('FO_FORUM_BOARD_', bid, '_MODERATE'), CONCAT('Modérer le forum ',board_name)
				FROM exo_forum_boards
				WHERE bid=$bid");
				
			//Ajouter le groupe
			$rq = $db->Send_Query("INSERT INTO exo_groups (gid, name, description, access_level)
				SELECT NULL, board_name, board_name, 3
				FROM exo_forum_boards
				WHERE bid=$bid");
			$gid = $db->last_insert_id();
			
			//Ajouter les droits sur le groupe
			$rq = $db->Send_Query("INSERT INTO exo_security_assign (ass_Type, ass_ACL, ass_cible) 
				SELECT 'G', acl_ID, $gid
				FROM exo_security_ACL
				WHERE acl_Key='FO_FORUM_BOARD_".$bid."_CREATE' OR acl_Key='FO_FORUM_BOARD_".$bid."_REPLY' OR acl_Key='FO_FORUM_BOARD_".$bid."_READ'");
				
			//Ajouter les droits pour le master
			$rq = $db->Send_Query("INSERT INTO exo_security_assign (ass_Type, ass_ACL, ass_cible) 
				SELECT 'U', acl_ID, U.uid
				FROM $db_name_characters.guild G
				LEFT JOIN $db_name_characters.characters C ON C.guid=G.leaderguid
				LEFT JOIN $db_name_realmd.account A ON A.id=C.account
				LEFT JOIN $db_name.exo_users U ON U.wow_id=A.id
				LEFT JOIN $db_name.exo_security_ACL ON acl_Key='FO_FORUM_BOARD_".$bid."_MODERATE'
				WHERE G.guildid='$guildid'");
			
				
			//Ajouter les membres aux groupes			
			$rq = $db->Send_Query("INSERT INTO exo_groups_users (gid, uid)
				SELECT $gid, U.uid
				FROM $db_name_characters.guild_member GM
				LEFT JOIN $db_name_characters.characters C ON C.guid=GM.guid
				LEFT JOIN $db_name_realmd.account A ON A.id=C.account
				LEFT JOIN $db_name.exo_users U ON U.wow_id=A.id
				WHERE GM.guildid='$guildid'
				GROUP BY U.uid");
			
			
			//Recherche de l'uid
			$uid = $db->get_result($db->Send_Query('SELECT uid FROM exo_guilds, exo_users WHERE wow_id=wowid AND guildid = '.$guildid), 0);
			
			//Recherche du nom
			$name = $db->get_result($db->Send_Query('SELECT name FROM exo_guilds WHERE guildid = '.$guildid), 0);
			
			//Envoie d'un MP
			$data = array();
			$data[0] = $name;
			$data[1] = '[url='.$ws_domain.'index.php?comp=profil&select='.$_SESSION['admin_uid'].']'.$_SESSION['admin_username'].'[/url]';
			$data[2] = $_POST['result'];
			$data[3] = $comment;	
			sendAutoMP(4, $uid, $data);
		
		}
	}	
	
	$_SESSION['BoxStateType'] = "Green";
	$_SESSION['BoxStateMsg'] = array_push ($_SESSION['BoxStateMsg'], "Validation du Guilde Réussie");
}

$query = "	SELECT guildid, name, leader, creation_time, last_edit_time
			FROM exo_guilds
			WHERE statut = 'EN_ATTENTE'
			ORDER BY last_edit_time";
$result = $db->Send_Query($query);
$rows = $db->loadObjectList($result);

if(!empty($rows)){
	$_SESSION['BoxStateType'] = "Green";
	$_SESSION['BoxStateMsg'] = array ("Chargement des Guildes en attente réussie");
}
else{
	$_SESSION['BoxStateType'] = "Red";
	$_SESSION['BoxStateMsg'] = array ("Aucun demande de validation de Guildes");
}


	
$TitlePage = 'Guildes';	

?>
