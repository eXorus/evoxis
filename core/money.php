<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_MONEY', 1 );


if(!empty($_GET['task']) && $_GET['task']=='process'){
	
	//Alliance
	if (!empty($_POST['form_aPourcentage']) && $_POST['form_aPourcentage']>0 && $_POST['form_aPourcentage']<101 && !empty($_POST['form_aNiveauMin']) && $_POST['form_aNiveauMin']>0 && !empty($_POST['form_aNiveauMax']) && $_POST['form_aNiveauMax']>0 && $_POST['form_aNiveauMin']<=$_POST['form_aNiveauMax']){
		
		$aPourcentage = intval($_POST['form_aPourcentage']);
		$aNiveauMin = intval($_POST['form_aNiveauMin']);
		$aNiveauMax = intval($_POST['form_aNiveauMax']);
		
		$query = "UPDATE exo_config SET conf_value='$aPourcentage' WHERE conf_key='MONEY_ALLIANCE_POURCENTAGE'";
		$result = $db->Send_Query($query);
		
		$query = "UPDATE exo_config SET conf_value='$aNiveauMin' WHERE conf_key='MONEY_ALLIANCE_LVL_MIN'";
		$result = $db->Send_Query($query);	
		
		$query = "UPDATE exo_config SET conf_value='$aNiveauMax' WHERE conf_key='MONEY_ALLIANCE_LVL_MAX'";
		$result = $db->Send_Query($query);
	}
	
	//Horde
	if (!empty($_POST['form_hPourcentage']) && $_POST['form_hPourcentage']>0 && $_POST['form_hPourcentage']<101 && !empty($_POST['form_hNiveauMin']) && $_POST['form_hNiveauMin']>0 && !empty($_POST['form_hNiveauMax']) && $_POST['form_hNiveauMax']>0 && $_POST['form_hNiveauMin']<=$_POST['form_hNiveauMax']){
		
		$hPourcentage = intval($_POST['form_hPourcentage']);
		$hNiveauMin = intval($_POST['form_hNiveauMin']);
		$hNiveauMax = intval($_POST['form_hNiveauMax']);
		
		$query = "UPDATE exo_config SET conf_value='$hPourcentage' WHERE conf_key='MONEY_HORDE_POURCENTAGE'";
		$result = $db->Send_Query($query);
		
		$query = "UPDATE exo_config SET conf_value='$hNiveauMin' WHERE conf_key='MONEY_HORDE_LVL_MIN'";
		$result = $db->Send_Query($query);	
		
		$query = "UPDATE exo_config SET conf_value='$hNiveauMax' WHERE conf_key='MONEY_HORDE_LVL_MAX'";
		$result = $db->Send_Query($query);
	}
	
	$msg = message::getInstance('WARNING','Votre demande ne peut pas être traitée', 'index.php?comp=money');

}


//Alliance Bourse
	$aBourse = $db_characters->get_result($db_characters->Send_Query("
		SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', $playerDataFieldMoney), ' ', -1) AS UNSIGNED) AS `money`
		FROM `characters`
		WHERE name='".MONEY_ALLIANCE_NOM."'"), 0);	
	$aBoursePO=floor($aBourse/10000);
	$aBourse= $aBourse-($aBoursePO*10000);
	$aBoursePA=floor($aBourse/100);
	$aBoursePC=$aBourse-($aBoursePA*100);

//Horde Bourse
	$hBourse = $db_characters->get_result($db_characters->Send_Query("
		SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', $playerDataFieldMoney), ' ', -1) AS UNSIGNED) AS `money`
		FROM `characters`
		WHERE name='".MONEY_HORDE_NOM."'"), 0);
	$hBoursePO=floor($hBourse/10000);
	$hBourse= $hBourse-($hBoursePO*10000);
	$hBoursePA=floor($hBourse/100);
	$hBoursePC=$hBourse-($hBoursePA*100);
	

//Alliance Acces
	$aAcces = $db_characters->get_result($db_characters->Send_Query("
		SELECT count(*)
		FROM `characters`
		WHERE name='".MONEY_ALLIANCE_NOM."' AND account='".intval($_SESSION['wow_id'])."'"), 0);
		
//Horde Acces
	$hAcces = $db_characters->get_result($db_characters->Send_Query("
		SELECT count(*)
		FROM `characters`
		WHERE name='".MONEY_HORDE_NOM."' AND account='".intval($_SESSION['wow_id'])."'"), 0);


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'money';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Argent' => 'index.php?comp=money',
'Principal' => ''
); 
?>