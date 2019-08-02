<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_BGCHECKFOCUS', 1 );
	
$guid = intval($_GET['select']);
	
$query = "	SELECT b.guid, b.wow_id, b.statut, b.name, b.race, b.class, b.background, b.creation_time, b.last_edit_time, u.username
			FROM exo_backgrounds b
			LEFT JOIN exo_users u ON u.wow_id=b.wow_id
			WHERE guid = $guid";
$result = $db->Send_Query($query);
$bg = $db->get_array($result);
	
$name = $bg['name'];
$wow_id = $bg['wow_id'];
$statut = $bg['statut'];
$guid = $bg['guid'];
$username = $bg['username'];
	
$race = print_race($bg['race']);
$class = print_class($bg['class']);
	
$background = $bg['background'];
	
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

$query = "	SELECT name
			FROM exo_backgrounds
			WHERE wow_id = '".intval($wow_id)."'
			ORDER BY name";
$result = $db->Send_Query($query);
$others = $db->loadObjectList($result);

$list_others = '';
foreach ($others as $other){
	$list_others .= $other->name.' ';
}


//Historiques
$query = "	SELECT id, guid, background, comment, validation_date, username
			FROM exo_backgrounds_history
			LEFT JOIN exo_users ON uid=validation_by
			WHERE guid = $guid
			ORDER BY validation_date DESC";
$result = $db->Send_Query($query);
$bg_h = $db->loadObjectList($result);

?>