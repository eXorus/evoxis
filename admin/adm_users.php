<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_USERS', 1 );
$tabGmLevel = array("Membre (0)", "Rôliste (1)", "MJ (3)", "MJ (4)", "MJ (5)", "MJ (6)");

$start = intval($_GET['start']);

if(!empty($_POST['form_login']) || !empty($_POST['form_group']) || !empty($_POST['form_gm'])){
	$login = mysql_real_escape_string($_POST['form_login']);
	$group = mysql_real_escape_string($_POST['form_group']);
	$gm = mysql_real_escape_string($_POST['form_gm']);
	
	if(!empty($_POST['form_login'])){
		$clausewhereL = "(u.username LIKE '$login' OR u.pseudo LIKE '$login')";
	}
	else {$clausewhereL = "1=1";}
	
	if(!empty($_POST['form_group'])){
		$clausewhereGR = "g.name LIKE '$group'";
	}
	else {$clausewhereGR = "1=1";}
	
	if(!empty($_POST['form_gm'])){
		$clausewhereGM = "wa.gmlevel LIKE '$gm'";
	}
	else {$clausewhereGM = "1=1";}
	$clausewhere = "WHERE $clausewhereL AND $clausewhereGR AND $clausewhereGM";
	
}else{
	$clausewhere = '';
}

		
$rq = $db->Send_Query("
			SELECT u.uid, u.wow_id, u.username, u.pseudo, g.name as groupName, wa.gmlevel
			FROM exo_users u 
			LEFT JOIN exo_groups_users gu ON gu.uid=u.uid
			LEFT JOIN exo_groups g ON g.gid=gu.gid
			LEFT JOIN $db_name_realmd.account wa ON wa.id= u.wow_id
			$clausewhere
			ORDER BY u.username
			LIMIT $start,$Nmax");
$users = $db->loadObjectList($rq);

$result = $db->Send_Query("SELECT COUNT(*) 
			FROM exo_users u 
			LEFT JOIN exo_groups_users gu ON gu.uid=u.uid
			LEFT JOIN exo_groups g ON g.gid=gu.gid
			LEFT JOIN $db_name_realmd.account wa ON wa.id= u.wow_id 
			$clausewhere");
$ligne = $db->get_row($result);
$Ntotal = $ligne[0];

$_SESSION['BoxStateType'] = "Green";
$_SESSION['BoxStateMsg'] = array ("Listage des $Ntotal comptes OK");

$TitlePage = 'Comptes';
?>
