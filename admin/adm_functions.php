<?php

function addWall($cat, $on, $message){
	global $db;
	
	$list_cat = array(
				'Anti-RP',
				'Insultes',
				'Cheat',
				'Auto: Ban',
				'Auto: Déban',
				'Autres'
				);
	$key = in_array($cat, $list_cat);
	
	if(!empty($cat) && $key==TRUE && !empty($_SESSION['admin_uid']) && !empty($on) && !empty($message)){
		$q = $db->Send_Query("INSERT INTO exo_wall (wid, wCat, wDate, wAuthor, wOn, wMessage) 
		VALUES (NULL, '".mysql_real_escape_string($cat)."', ".time().", ".intval($_SESSION['admin_uid']).", ".intval($on).", '".mysql_real_escape_string($message)."')");
	}
}

?>
