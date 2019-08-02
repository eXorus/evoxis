<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_BGCHECK', 1 );

$_SESSION['BoxStateMsg'] = array ();

if ($_GET['task']=='process_bgcheck' && !empty($_POST['guid']) && !empty($_POST['wow_id']) && $secureObject->verifyAuthorization('BO_BGCHECK_VALIDATE')==TRUE){
	$guid = intval($_POST['guid']);
	$wow_id = intval($_POST['wow_id']);
	$name = mysql_real_escape_string($_POST['name']);
	$comment = mysql_real_escape_string($_POST['comment']);
	$favourite = mysql_real_escape_string($_POST['form_favourite']);
	
	//Favourite
	if($favourite=="on"){
		$query_fav=", favourite_date=".time().", favourite_by=".$_SESSION['admin_uid']." ";
	}
	
	//Historique
	$aS = $db->get_array($db->Send_Query("SELECT background FROM exo_backgrounds WHERE guid = $guid"));
	$bS = $aS['background'];	
	$qh = "INSERT INTO exo_backgrounds_history(id, guid, background, comment, validation_date, validation_by) 
			VALUES(NULL, $guid, '".mysql_real_escape_string($bS)."', '$comment', ".time().", ".$_SESSION['admin_uid'].") ";
	$r = $db->Send_Query($qh);

	if($_POST['result']=='NON_VALIDE' || $_POST['result']=='VALIDE'){
		$query_update = "UPDATE exo_backgrounds SET statut='".$_POST['result']."', first_validation_time='".time()."' $query_fav WHERE guid='$guid' AND statut='EN_ATTENTE'";
		$result_update = $db->Send_Query($query_update);
		$update = $db->num_rows();
		
		if($update==1){
			//Recherche de l'uid
			$uid = $db->get_result($db->Send_Query('SELECT uid FROM exo_users WHERE wow_id = '.$wow_id), 0);
			
			//Envoie d'un MP
			$data = array();
			$data[0] = $name;
			$data[1] = '[url='.$ws_domain.'index.php?comp=profil&select='.$_SESSION['admin_uid'].']'.$_SESSION['admin_username'].'[/url]';
			$data[2] = $_POST['result'];
			$data[3] = $comment;	
			sendAutoMP(2, $uid, $data);
			
			//On verifie si on peut débannir le compte
			if($_POST['result']=='VALIDE'){
				//Recherche du nombre de persos invalide restant
				$return_query = $db->Send_Query("
				SELECT count(*)
				FROM $db_name_characters.`characters` C
				LEFT JOIN evoxis.exo_backgrounds B ON C.guid = B.guid
				WHERE CAST( SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', $playerDataFieldLevel), ' ', -1) AS UNSIGNED) >9
				AND B.statut != 'VALIDE'
				AND C.account=".$wow_id."
				");
				$ligne = $db->get_row($return_query);
				$nb_perso_restant = $ligne[0];
			
				
				if($nb_perso_restant==0){
							
					
					//débannir
					$query = "DELETE FROM account_banned WHERE id = ".$wow_id."";
					$result = $db_realmd->Send_Query($query);
					
					//Envoie d'un MP
					$data = array();
					sendAutoMP(3, $uid, $data);				
					
				}
			}
		}
	}	
	
	$_SESSION['BoxStateType'] = "Green";
	$_SESSION['BoxStateMsg'] = array_push ($_SESSION['BoxStateMsg'], "Validation du BG Réussie");
}

$query = "	SELECT guid, name, race, class, creation_time, last_edit_time
			FROM exo_backgrounds
			WHERE statut = 'EN_ATTENTE'
			ORDER BY last_edit_time";
$result = $db->Send_Query($query);
$rows = $db->loadObjectList($result);

if(!empty($rows)){
	$_SESSION['BoxStateType'] = "Green";
	$_SESSION['BoxStateMsg'] = array ("Chargement des BGs en attente réussie");
}
else{
	$_SESSION['BoxStateType'] = "Red";
	$_SESSION['BoxStateMsg'] = array ("Aucun demande de validation de BG");
}


	
$TitlePage = 'BGCheck';	

?>
