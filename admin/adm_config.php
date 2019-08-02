<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_CONFIG', 1 );



if(!empty($_GET['mod']) && !empty($_GET['mod'])){
	if($_GET['mod']=='wow'){
						
		if(!empty($_GET['task']) &&$_GET['task']=='process'){
		
			$msg = message::getInstance('SUCCESS','Configuration de wow mis à jour', 'index.php?comp=config&mod=wow');
		}
		$TitlePage = 'Config > WoW';
	}
	elseif($_GET['mod']=='site'){
				
		if(!empty($_GET['task']) &&$_GET['task']=='process'){
		
			if(!empty($_POST['form_offlineAcces']) && $_POST['form_offlineAcces']=='on'){$value=0;}
			else{$value=1;}

			$query = "UPDATE exo_config SET conf_value='$value' WHERE conf_key='WEBSITE_OFFLINE'";
			$result = $db->Send_Query($query);
			
			$query = "UPDATE exo_config SET conf_value='".mysql_real_escape_string($_POST['form_offlinePwd'])."' WHERE conf_key='WEBSITE_OFFLINE_PWD'";
			$result = $db->Send_Query($query);
			
			$query = "UPDATE exo_config SET conf_value='".mysql_real_escape_string($_POST['form_offlineReason'])."' WHERE conf_key='WEBSITE_OFFLINE_INFO'";
			$result = $db->Send_Query($query);
			
			$query = "UPDATE exo_config SET conf_value='".mysql_real_escape_string($_POST['form_insevoCharte'])."' WHERE conf_key='CHARTE_EVOXIS'";
			$result = $db->Send_Query($query);
		
			$query = "UPDATE exo_config SET conf_value='".mysql_real_escape_string($_POST['form_realmlist'])."' WHERE conf_key='REALMLIST'";
            		$result = $db->Send_Query($query);	

			$query = "UPDATE exo_config SET conf_value='".mysql_real_escape_string($_POST['form_rdrop'])."' WHERE conf_key='RATES_DROP'";
            		$result = $db->Send_Query($query);	
			$query = "UPDATE exo_config SET conf_value='".mysql_real_escape_string($_POST['form_rmonstres'])."' WHERE conf_key='RATES_MONSTRES'";
            		$result = $db->Send_Query($query);
			$query = "UPDATE exo_config SET conf_value='".mysql_real_escape_string($_POST['form_rquetes'])."' WHERE conf_key='RATES_QUETES'";
            		$result = $db->Send_Query($query);
			$query = "UPDATE exo_config SET conf_value='".mysql_real_escape_string($_POST['form_rexploration'])."' WHERE conf_key='RATES_EXPLORATION'";
            		$result = $db->Send_Query($query);
			
			$query = "UPDATE exo_config SET conf_value='".mysql_real_escape_string($_POST['form_wowversion'])."' WHERE conf_key='WOW_VERSION'";
            		$result = $db->Send_Query($query);
			
			$query = "UPDATE exo_config SET conf_value='".mysql_real_escape_string($_POST['form_tplDefaut'])."' WHERE conf_key='TEMPLATE_DEFAULT'";
			$result = $db->Send_Query($query);
			
			$query = "UPDATE exo_config SET conf_value='".mysql_real_escape_string($_POST['form_boxdefilante'])."' WHERE conf_key='BOX_DEFILANTE'";
			$result = $db->Send_Query($query);
			
			if(!empty($_POST['form_shoutboxMessage']) && $_POST['form_shoutboxMessage']=='on'){$value=1;}
			else{$value=0;}

			$query = "UPDATE exo_config SET conf_value='$value' WHERE conf_key='SHOUTBOX_VISITEUR_ACTIVATE'";
			$result = $db->Send_Query($query);
			
			if(!empty($_POST['form_insevoActivate']) && $_POST['form_insevoActivate']=='on'){$value=1;}
			else{$value=0;}

			$query = "UPDATE exo_config SET conf_value='$value' WHERE conf_key='INSEVO_ACTIVATE'";
			$result = $db->Send_Query($query);
			
			$msg = message::getInstance('SUCCESS','Configuration du site mis à jour', 'index.php?comp=config&mod=site');
		}
		$TitlePage = 'Config > Site';
	}
	else{
		$msg = message::getInstance('ERROR','Impossible de trouver la configuration', 'index.php?comp=config&mod=site');
	}
}
else{
	$msg = message::getInstance('ERROR','Impossible de trouver la configuration', 'index.php?comp=config&mod=site');
}
?>

