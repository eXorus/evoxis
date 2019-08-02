<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_ASK', 1 );

$start = intval($_GET['start']);
$type = $_GET['type'];

if(!empty($_POST['form_type']) || !empty($_POST['form_etat']) || !empty($_POST['form_assign'])){
	$type = mysql_real_escape_string($_POST['form_type']);
	$etat = mysql_real_escape_string($_POST['form_etat']);
	$assign = mysql_real_escape_string($_POST['form_assign']);
	
	if(!empty($_POST['form_type'])){		
		$clausewhereT = "acTitle LIKE '%$type%'";
	}
	else {$clausewhereT = "1=1";}
	
	if(!empty($_POST['form_etat'])){
		$clausewhereE = "aState LIKE '%$etat%'";
	}
	else {$clausewhereE = "1=1";}
	
	if(!empty($_POST['form_assign'])){
		$clausewhereA = "U.username LIKE '%$assign%'";
	}
	else {$clausewhereA = "1=1";}
	$clausewhere = "WHERE $clausewhereT AND $clausewhereE AND $clausewhereA";
	
}else{
	$clausewhere = '';
}

if($type=='WAIT' or $type=='OPEN' or $type=='VALIDATE' or $type=='ASSIGN' or $type=='DONE' or $type=='REFUSED'){
	
	if($type=='ASSIGN') $wheremax = "AND aAssignTo=".$_SESSION['admin_uid'];
	
	$query = "
		SELECT aID, acTitle, aState, aDateOpen, aDateValidate, aDateAssign, aDateDone, aDateRefused,  U.username as aAssignTo, CONCAT_WS('',A.username, exo_backgrounds.name, exo_guilds.name) AS cible
		FROM exo_ask
		LEFT JOIN exo_ask_config ON aType=acID
		LEFT JOIN exo_users A ON (A.uid=aCible AND acCible='CT')
		LEFT JOIN exo_backgrounds ON (guid=aCible AND acCible='PV')
		LEFT JOIN exo_guilds ON (guildid=aCible AND acCible='GD')
		LEFT JOIN exo_users U ON U.uid=aAssignTo
		WHERE aState = '$type' 
		$wheremax 
		ORDER BY aDateValidate DESC, aDateOpen DESC
		LIMIT $start,$Nmax";
	$query2 = "SELECT COUNT(*) FROM exo_ask WHERE state = '$type'";
	$result = $db->Send_Query($query2);
	$ligne = $db->get_row($result);
	$Ntotal = $ligne[0];	

	$_SESSION['BoxStateType'] = "Green";
	$_SESSION['BoxStateMsg'] = array ("Listage des $Ntotal demandes de type $type OK");
}
else{
	$query = "
		SELECT aID, acTitle, aState, aDateOpen, aDateValidate, aDateAssign, aDateDone, aDateRefused, U.username as aAssignTo, CONCAT_WS('',A.username, exo_backgrounds.name, exo_guilds.name) AS cible
		FROM exo_ask
		LEFT JOIN exo_ask_config ON aType=acID
		LEFT JOIN exo_users A ON (A.uid=aCible AND acCible='CT')
		LEFT JOIN exo_backgrounds ON (guid=aCible AND acCible='PV')
		LEFT JOIN exo_guilds ON (guildid=aCible AND acCible='GD')
		LEFT JOIN exo_users U ON U.uid=aAssignTo
		$clausewhere 
		ORDER BY aDateOpen DESC 
		LIMIT $start,$Nmax";
	$query2 = "
		SELECT COUNT(*)
		FROM exo_ask
		LEFT JOIN exo_ask_config ON aType=acID
		LEFT JOIN exo_users A ON (A.uid=aCible AND acCible='CT')
		LEFT JOIN exo_backgrounds ON (guid=aCible AND acCible='PV')
		LEFT JOIN exo_guilds ON (guildid=aCible AND acCible='GD')
		LEFT JOIN exo_users U ON U.uid=aAssignTo
		$clausewhere 
		ORDER BY aDateOpen DESC 
		LIMIT $start,$Nmax";
	$result = $db->Send_Query($query2);
	$ligne = $db->get_row($result);
	$Ntotal = $ligne[0];	
		
	$_SESSION['BoxStateType'] = "Green";
	$_SESSION['BoxStateMsg'] = array ("Listage des $Ntotal demandes OK");
}
$result = $db->Send_Query($query);
$rows = $db->loadObjectList($result);

$TitlePage = 'Ask';
?>