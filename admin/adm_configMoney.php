<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_CONFIGMONEY', 1 );


if(!empty($_GET['task']) && $_GET['task']=='process'){
	
	//Alliance
	if (!empty($_POST['form_aFonction']) && !empty($_POST['form_aNom'])){
		
		$aFonction = mysql_real_escape_string($_POST['form_aFonction']);
		$aNom = mysql_real_escape_string($_POST['form_aNom']);
		
		$query = "UPDATE exo_config SET conf_value='$aFonction' WHERE conf_key='MONEY_ALLIANCE_FONCTION'";
		$result = $db->Send_Query($query);
		
		$query = "UPDATE exo_config SET conf_value='$aNom' WHERE conf_key='MONEY_ALLIANCE_NOM'";
		$result = $db->Send_Query($query);	
	}
	
	//Horde
	if (!empty($_POST['form_hFonction']) && !empty($_POST['form_hNom'])){
	
		$hFonction = mysql_real_escape_string($_POST['form_hFonction']);
		$hNom = mysql_real_escape_string($_POST['form_hNom']);
		
		$query = "UPDATE exo_config SET conf_value='$hFonction' WHERE conf_key='MONEY_HORDE_FONCTION'";
		$result = $db->Send_Query($query);
		
		$query = "UPDATE exo_config SET conf_value='$hNom' WHERE conf_key='MONEY_HORDE_NOM'";
		$result = $db->Send_Query($query);	
	}
	
	$msg = message::getInstance('SUCCESS','Configuration de money réussie', 'index.php?comp=configMoney');
}
?>

