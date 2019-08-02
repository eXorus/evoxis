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

//Connexion à WoW Realmd
$db_realmd = new mysql($db_host_realmd,$db_username_realmd,$db_password_realmd,$db_name_realmd);
$db_realmd->connect($db_realmd->host,$db_realmd->user,$db_realmd->pass,$db_realmd->base, TRUE) or die( 'MySQL Lost: Realmd' );

//#################################################################


//Recherche des persos invalides
$q1 = "
	SELECT C.account, C.name
	FROM $db_name_characters.`characters` C
	LEFT JOIN evoxis.exo_backgrounds B ON C.guid = B.guid
	LEFT JOIN $db_name_realmd.account_banned A ON A.id = C.account AND A.active=1
	WHERE CAST( SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', $playerDataFieldLevel), ' ', -1) AS UNSIGNED) >9
	AND B.statut != 'VALIDE'
	AND A.id IS NULL
	GROUP BY C.account";
$r1 = $db->Send_Query($q1);
$o1 = $db->loadObjectList($r1);

$customQuery = "INSERT INTO `account_banned` ( `id` , `bandate` , `unbandate` , `bannedby` , `banreason` , `active` ) VALUES";
$num = 0;

foreach($o1 as $object){
	$customQuery .= "('".$object->account."', '".time()."', '".time()."', 'BGCHECK du ".date("Ymd")."', 'Perso sans bg et supérieur/égal au level 10: ".$object->name."', '1'),";
	$num ++;
}
$customQuery = substr($customQuery,0,strlen($customQuery)-1);
$customQuery .= ";";

$db_realmd->Send_Query($customQuery);

$db->Send_Query("UPDATE exo_config SET conf_value='".time()."' WHERE conf_key='CRON_BGCHECK'");
$db->Send_Query("UPDATE exo_config SET conf_value='".$num."' WHERE conf_key='CRON_BGCHECK_NUM'");

?>
