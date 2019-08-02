<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_INFOBOX
define( '_VALID_CORE_INFOBOX', 1 );

//Serveur On ou OFF
if(@fsockopen($db_host_realmd, 8085,  $errno, $errstr, 1)){
	$state_serveur = '<img src="./templates/default/ico/up.gif" alt="Serveur UP"  onmouseover="Tip(\'Il&nbsp;y&nbsp;a&nbsp;'.$count_players.' &nbsp;joueurs&nbsp;en&nbsp;ligne\')" onmouseout="UnTip()"/>';
}
else{
	$state_serveur = '<img src="./templates/default/ico/down.png" alt="Serveur DOWN"  onmouseover="Tip(\'Serveur&nbsp;arrêté\')" onmouseout="UnTip()" />';
}

/*debut du cache*/
$cacheInfobox = 'cache/infobox.html';
$expireInfobox = time() - 60 ; // valable une minute

if(file_exists($cacheInfobox) && filemtime($cacheInfobox) > $expireInfobox){
}
else
{

	//Nb de joueurs en ligne
	$count_players= 10 * $db_realmd->get_result($db_realmd->Send_Query('SELECT COUNT(*) AS nbr_joueurs FROM account WHERE online = 1'),0);

	//Nb de membres
	$count_members= $db_realmd->get_result($db_realmd->Send_Query('SELECT COUNT(*) AS nbr_members FROM account'),0);

	//Nb de persos
	$count_persos= $db_realmd->get_result($db_realmd->Send_Query('SELECT SUM(numchars) AS nbr_persos FROM realmcharacters'),0);

	//ACTIFS sur les 15 derniers jours
	$limit = time() - (15*24*60*60);
	$count_actifs= 10 * $db->get_result($db->Send_Query("
	SELECT COUNT(*)
	FROM evoxis.`exo_users`
	LEFT JOIN $db_name_realmd.`account` ON $db_name_realmd.`account`.id=evoxis.`exo_users`.wow_id
	WHERE 
	evoxis.`exo_users`.last_date_connect>$limit
	AND
	TO_DAYS( NOW( ) ) - TO_DAYS( $db_name_realmd.`account`.last_login ) <=15"),0);

}
?>
