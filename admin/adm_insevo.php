<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_INSEVO', 1 );

$start = intval($_GET['start']);
$type = $_GET['type'];

if($type=='OK' or $type=='NOK' or $type=='WAIT'){

	$query = "
		SELECT insevo_id,login, time_creation, time_validation, state, comment
		FROM exo_insevo
		WHERE state = '$type'
		ORDER BY time_validation DESC, time_creation DESC
		LIMIT $start,$Nmax";
	$query2 = "SELECT COUNT(*) FROM exo_insevo WHERE state = '$type'";
	$result = $db->Send_Query($query2);
	$ligne = $db->get_row($result);
	$Ntotal = $ligne[0];	

	$_SESSION['BoxStateType'] = "Green";
	$_SESSION['BoxStateMsg'] = array ("Listage des $Ntotal inscriptions de type $type OK");
}
else{
	$query = "
		SELECT insevo_id,login, time_creation, time_validation, state, comment
		FROM exo_insevo
		ORDER BY time_creation DESC 
		LIMIT $start,$Nmax";
	$query2 = "SELECT COUNT(*) FROM exo_insevo";
	$result = $db->Send_Query($query2);
	$ligne = $db->get_row($result);
	$Ntotal = $ligne[0];	
		
	$_SESSION['BoxStateType'] = "Green";
	$_SESSION['BoxStateMsg'] = array ("Listage des $Ntotal inscriptions OK");
}
$result = $db->Send_Query($query);
$rows = $db->loadObjectList($result);

$TitlePage = 'Insevo';
?>