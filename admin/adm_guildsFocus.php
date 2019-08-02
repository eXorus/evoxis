<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_GUILDSFOCUS', 1 );
	
$guildid = intval($_GET['select']);
	
$query = "
	SELECT g.guildid, g.name, g.leader, g.creation_time, g.last_edit_time, g.background, g.goals, g.rules, g.hall, g.hierarchy, g.accepted, g.statut, GROUP_CONCAT(
	DISTINCT c.name ORDER BY c.name SEPARATOR ', ') as membres
	FROM exo_guilds g
	LEFT JOIN $db_name_characters.guild_member gm ON g.guildid = gm.guildid
	LEFT JOIN $db_name_characters.`characters` c ON c.guid = gm.guid
	WHERE g.guildid='$guildid'
	GROUP BY g.name";
$result = $db->Send_Query($query);
$bg = $db->get_array($result);
	
$name = $bg['name'];
$leader = $bg['leader'];
$background = $bg['background'];
$goals = $bg['goals'];	
$rules = $bg['rules'];	
$hall = $bg['hall'];	
$hierarchy = $bg['hierarchy'];	
$accepted = $bg['accepted'];	
$statut = $bg['statut'];
$membres = $bg['membres'];
	
	
if(empty($bg['creation_time'])){
	$creation_time = 'Non disponible pour le moment';
}
else{
	$creation_time = $bg['creation_time'];
}
	
if(empty($bg['last_edit_time'])){
	$last_edit_time = 'Non disponible pour le moment';
}
else{
	$last_edit_time = $bg['last_edit_time'];
}

?>
