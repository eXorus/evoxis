<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_BG_WRITE
define( '_VALID_CORE_BG_WRITE', 1 );

if(!empty($_GET['task']) && $_GET['task']=="process"){

	//Récupère le message
	$message = mysql_real_escape_string($_POST['message']);
	$guid = intval($_POST['guid']);
	
	//recherche des infos
	$query2 = "	SELECT statut
				FROM exo_backgrounds
				WHERE guid = $guid";
	$result2 = $db->Send_Query($query2);
	$bg2 = $db->get_array($result2);
	
	if($bg2['statut']=='INDISPONIBLE' || $bg2['statut']=='NON_VALIDE'){
		$dbstatut = " statut='EN_REDACTION', ";
	}
	
	//Requete
	$query = "	UPDATE exo_backgrounds
				SET 	$dbstatut 
						background='$message', 
						last_edit_time='".time()."'  
				WHERE guid = '$guid' AND wow_id='".$_SESSION['wow_id']."'";
	$result = $db->Send_Query($query);
	
	//Indices
	update_ivo('nb_bg_edition');
	
	//Spyvo
	$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'BG', 'Edit bg;WOW_ID='.$_SESSION['wow_id'].';GUID='.$guid);
	
	$msg = message::getInstance('SUCCESS','Background enregistré', 'index.php?comp=bg_show&amp;guid='.$guid);
}
else if (!empty($_GET['task']) && $_GET['task']=="ask_valid"){

	$guid = intval($_GET['guid']);
	
	//Requete
	$query = "	UPDATE exo_backgrounds
				SET 	statut='EN_ATTENTE', ask_validation='".time()."'
				WHERE guid = '$guid' AND wow_id='".$_SESSION['wow_id']."'";
	$result = $db->Send_Query($query);
	
	//Spyvo
	$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'BG', 'Ask valid;WOW_ID='.$_SESSION['wow_id'].';GUID='.$guid);
		
	$msg = message::getInstance('SUCCESS','Demande de validation du background enregistrée', 'index.php?comp=bg');
}
else{

	if(!empty($_GET['guid']) && !empty($_SESSION['wow_id'])){

		$guid = intval($_GET['guid']);
		
		$query = "	SELECT guid, wow_id, statut, name, background, creation_time, last_edit_time
					FROM exo_backgrounds
					WHERE guid = '$guid'
					AND wow_id = '".$_SESSION['wow_id']."'";
		$result = $db->Send_Query($query);
		$bg = $db->get_array($result);
		
		if(empty($bg)) header ('location: index.php?comp=bg'); 

	}
}

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'backgrounds';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Backgrounds' => 'index.php?comp=bg',
'Rédaction' => ''
);
$ws_name_perso = 'Evoxis v5 - Rédaction d\'un background';

?>