#!/usr/bin/php5-cgi

<?php
//#################################################################
//Require_one
require_once("../config.php");
require_once("../mysql.php");
require_once("../fct_utile.php");

//MySQL
$db = new mysql($db_host,$db_username,$db_password,$db_name, TRUE);
$db->connect($db->host,$db->user,$db->pass,$db->base) or die( 'MySQL Lost: WS' );

//Connexion a Wow Characters
$db_characters = new mysql($db_host_characters,$db_username_characters,$db_password_characters,$db_name_characters);
$db_characters->connect($db_characters->host,$db_characters->user,$db_characters->pass,$db_characters->base, TRUE) or die( 'MySQL Lost: Characters' );
//#################################################################


//Recherche dans exo_backgrounds
$q1 = "SELECT guid FROM exo_backgrounds";
$r1 = $db->Send_Query($q1);
$o1 = $db->loadObjectList($r1);

$bg_to_delete = array();

foreach($o1 as $object){
	$q2 = "SELECT COUNT(*) FROM `characters` WHERE `guid`='".$object->guid."'";
	$r2 = $db_characters->Send_Query($q2);
	$l2 = $db_characters->get_row($r2);
	
	if($l2[0]==0){
		$bg_to_delete[] = $object->guid;
	}
}

//Recherche dans characters
$q1 = "SELECT guid, account, name, race, class FROM `characters`";
$r1 = $db_characters->Send_Query($q1);
$o1 = $db_characters->loadObjectList($r1);

foreach($o1 as $object){
	$q2 = "SELECT COUNT(*) FROM exo_backgrounds WHERE `guid`='".$object->guid."'";
	$r2 = $db->Send_Query($q2);
	$l2 = $db->get_row($r2);
	
	if($l2[0]==0){
		//Création
		$query = "INSERT INTO exo_backgrounds(guid, wow_id, statut, name, race, class, creation_time) 
				VALUES('".$object->guid."','".$object->account."', 'INDISPONIBLE', '".$object->name."', '".$object->race."', '".$object->class."', '".time()."')";
		$db->Send_Query($query);
			
		//Indices
		$result_4 = $db->Send_Query("SELECT uid FROM `exo_users` WHERE `wow_id`='".$object->account."'");
		$ligne_4 = $db->get_row($result_4);
		$uid = $ligne_4[0];			
		//Indices
		update_ivo('nb_bg_create', $uid);
	}
}

//Security
if (count($bg_to_delete)<1000){
	$query_bg_to_delete = "DELETE FROM exo_backgrounds WHERE guid='0'";

	foreach($bg_to_delete as $bg){
		$query_bg_to_delete .= " OR guid='".$bg."'";
	}
	$delete = $db->Send_Query($query_bg_to_delete);
}

$db->Send_Query("UPDATE exo_config SET conf_value='".time()."' WHERE conf_key='CRON_SYNCHRO_BG'");

?>
