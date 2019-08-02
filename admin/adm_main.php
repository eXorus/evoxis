<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_MAIN', 1 );

if(!empty($_POST['objectif'])){
	$obj = mysql_real_escape_string($_POST['objectif']);
	$db->Send_Query("UPDATE exo_groups_objectifs SET objectif='".$obj."' WHERE uid = ".$_SESSION['admin_uid']."");
	
	$_SESSION['BoxStateType'] = "Green";
	$_SESSION['BoxStateMsg'] = array ("Mise à jour de l'objectif OK");
}

// En attente de validation
	//Guildes à valider
	$count_guildes = $db->get_result($db->Send_Query("SELECT COUNT(*) FROM exo_guilds WHERE statut = 'EN_ATTENTE'"),0);

	//Backgrounds à valider
	$count_backgrounds = $db->get_result($db->Send_Query("SELECT COUNT(*) FROM exo_backgrounds WHERE statut = 'EN_ATTENTE'"),0);

	//Inscriptions à valider
	$count_insevos = $db->get_result($db->Send_Query("SELECT COUNT(*) FROM exo_insevo WHERE state = 'WAIT'"),0);
	
//Demandes
	$count_askOPEN = $db->get_result($db->Send_Query("SELECT COUNT(*) FROM exo_ask WHERE aState = 'OPEN'"),0);
	$count_askASSIGN = $db->get_result($db->Send_Query("SELECT COUNT(*) FROM exo_ask WHERE aState = 'ASSIGN' AND aAssignTo=".$_SESSION['admin_uid'].""),0);
	
//Objectif
	$objectif = $db->get_result($db->Send_Query("SELECT objectif FROM exo_groups_objectifs WHERE uid = ".$_SESSION['admin_uid'].""),0);

?>


