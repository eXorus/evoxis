<?php

require_once("../config.php");
require_once("../mysql.php");

$db = new mysql($db_host,$db_username,$db_password,$db_name, TRUE);
$db->connect($db->host,$db->user,$db->pass,$db->base) or die( 'MySQL Lost: WS' );

// Membres
$req = "SELECT username, pseudo,  CONCAT_WS('.',exo_pictures.id,exo_pictures.image_extension) as image
	FROM exo_users 
	LEFT JOIN exo_pictures ON type=1 AND selected=1 AND exo_users.uid=exo_pictures.uid
	WHERE username LIKE '".mysql_real_escape_string($_GET['q'])."%' OR pseudo LIKE '".mysql_real_escape_string($_GET['q'])."%'";
$res = $db->Send_Query($req);
$row = $db->loadObjectList($res);

$xml = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$xml .= '<root>';

if(!empty($row)){
	$xml .= '<users>';
	foreach($row as $o){	
		$xml .= '<user>';
		$xml .= '<username>' . htmlspecialchars($o->username) . '</username>';
		$xml .= '<pseudo>' . htmlspecialchars($o->pseudo) . '</pseudo>';
		$xml .= (empty($o->image)) ? '<image>0</image>' : '<image>'.htmlspecialchars($o->image).'</image>';
		$xml .= '</user>';
		
	}
	$xml .= '</users>';
}

// Groupes
$req = "SELECT name, GROUP_CONCAT(U.username SEPARATOR ', ') as membres
	FROM exo_groups G
	INNER JOIN exo_groups_users GU ON GU.gid=G.gid
	INNER JOIN exo_users U ON U.uid=GU.uid
	WHERE name LIKE '".mysql_real_escape_string($_GET['q'])."%'
	GROUP BY G.gid";
$res = $db->Send_Query($req);
$row = $db->loadObjectList($res);

if(!empty($row)){
	$xml .= '<groups>';

	foreach($row as $o){	
		$xml .= '<group>';
		$xml .= '<name>' . htmlspecialchars($o->name) . '</name>';
		$xml .= (empty($o->membres)) ? '<membres>0</membres>' : '<membres>'.htmlspecialchars($o->membres).'</membres>';
		$xml .= '</group>';
		
	}
	$xml .= '</groups>';
}


// Guildes
$req = "SELECT G.name, GROUP_CONCAT(U.username SEPARATOR ', ') as membres
	FROM exo_guilds G
	INNER JOIN $db_name_characters.guild_member GM ON G.guildid = GM.guildid
	INNER JOIN $db_name_characters.`characters` C ON C.guid = GM.guid
	INNER JOIN exo_users U ON U.wow_id=C.account
	WHERE G.name LIKE '".mysql_real_escape_string($_GET['q'])."%'
	GROUP BY G.guildid";
$res = $db->Send_Query($req);
$row = $db->loadObjectList($res);

if(!empty($row)){
	$xml .= '<guilds>';

	foreach($row as $o){	
		$xml .= '<guild>';
		$xml .= '<name>' . htmlspecialchars($o->name) . '</name>';
		$xml .= (empty($o->membres)) ? '<membres>0</membres>' : '<membres>'.htmlspecialchars($o->membres).'</membres>';
		$xml .= '</guild>';
		
	}
	$xml .= '</guilds>';
}



$xml .= '</root>';




// Affichage
header('Content-type: text/xml; charset=ISO-8859-1');
echo $xml;

?>
