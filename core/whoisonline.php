<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_WHOISONLINE
define( '_VALID_CORE_WHOISONLINE', 1 );

if(!empty($_SESSION['uid'])){
	
	$result = $db->Send_Query("
	SELECT COUNT(*) FROM exo_whoisonline WHERE online_id = '".intval($_SESSION['uid'])."'");
	$ligne = $db->get_row($result);	
	$match = $ligne[0];
	
	if ($match==0){
		$db->Send_Query("INSERT INTO exo_whoisonline (online_id, online_time, online_ip) 
			VALUES ('".intval($_SESSION['uid'])."', '".time()."', '".ip2long($_SERVER['REMOTE_ADDR'])."')");
	}
	else{		
		$db->Send_Query("UPDATE exo_whoisonline 
			SET online_time='".time()."' WHERE online_id='".intval($_SESSION['uid'])."'");
	}
}
else{

	$result = $db->Send_Query("
	SELECT COUNT(*) FROM exo_whoisonline WHERE online_ip = '".ip2long($_SERVER['REMOTE_ADDR'])."'");
	$ligne = $db->get_row($result);	
	$match = $ligne[0];
	
	if ($match==0){
		$db->Send_Query("INSERT INTO exo_whoisonline (online_id, online_time, online_ip) 
			VALUES ('0', '".time()."', '".ip2long($_SERVER['REMOTE_ADDR'])."')");
	}
	else{
		$db->Send_Query("UPDATE exo_whoisonline 
			SET online_time='".time()."' WHERE online_ip = '".ip2long($_SERVER['REMOTE_ADDR'])."' AND online_id='0'");
	}
}

//Nombre de personnes en ligne VISITEUR
//**********************
$result = $db->Send_Query("SELECT COUNT(*) FROM exo_whoisonline WHERE online_id = 0");
$ligne = $db->get_row($result);
$nb_visiteurs = $ligne[0];

//Nombre de personnes en ligne MEMBRES
//**********************
$result = $db->Send_Query("SELECT COUNT(*) FROM exo_whoisonline WHERE online_id > 0");
$ligne = $db->get_row($result);
$nb_membres = $ligne[0];

//Nombre de connecé TOTAL
//**********************
$nb_online = $nb_membres + $nb_visiteurs;

//Affichage de la liste des connecte
//**********************
$rq = $db->Send_Query("
			SELECT online_id, online_time, pseudo
			FROM exo_whoisonline
			LEFT JOIN exo_users ON uid=online_id
			WHERE online_id > 0
			ORDER BY pseudo");
$connecte_membres = $db->loadObjectList($rq);


?>