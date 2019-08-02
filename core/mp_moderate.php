<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_MP_MODERATE', 1 );

/*
 * RECUPERATION DES MPs A TRAITER 
 *
 * 
*/



$tabSelectionMPs = array();
if(!empty($_POST['action'])){
	$action = $_POST['action'];
	
	foreach($_POST as $key => $value){
		if(substr_count($key, "dpID_")==1 && $value=="on"){
			array_push($tabSelectionMPs, intval(substr($key,5)));
		}
	}
}
elseif(!empty($_GET['action'])){
	$action = $_GET['action'];
	
	array_push($tabSelectionMPs, intval($_GET['dpID']));
}

$queryFilter = '';
foreach($tabSelectionMPs as $key => $value){
	if($queryFilter!='') $queryFilter .= ', ';
	$queryFilter .= $value;
}

/*
 * TRAITEMENT DES ACTIONS DEMANDEES
 *
 * 
*/
if(!empty($_GET['task']) && $_GET['task']=="process" && !empty($_POST['action']) && (!empty($queryFilter) || $_POST['action']=='addFolder' || $_POST['action']=='editFolder'  || $_POST['action']=='deleteFolder')){
	
	if($_POST['action']=='addFolder'){
		$folderToAdd = mysql_real_escape_string($_POST['folderToAdd']);
		
		$result = $db->Send_Query("INSERT INTO exo_mp_folders(mfID, mfOwner, mfLibelle) VALUES(NULL, ".$_SESSION['uid'].", '$folderToAdd')");	
		
		$msg = message::getInstance('SUCCESS','Ajout du dossier réussi', 'index.php?comp=mp');
	
	}
	elseif($_POST['action']=='editFolder'){
		$folderToEdit = mysql_real_escape_string($_POST['folderToEdit']);
		$mfID = intval($_POST['mfID']);
		
		$result = $db->Send_Query("UPDATE exo_mp_folders SET mfLibelle='$folderToEdit' WHERE mfID=$mfID AND mfOwner=".$_SESSION['uid']."");	
		
		$msg = message::getInstance('SUCCESS','Edition du dossier réussi', 'index.php?comp=mp');
		
	}
	elseif($_POST['action']=='deleteFolder'){
		$mfID = intval($_POST['mfID']);
		
		$result = $db->Send_Query("DELETE A FROM exo_mp_appartient A, exo_mp_folders F WHERE F.mfID=A.mfID AND A.mfID=$mfID AND F.mfOwner=".$_SESSION['uid']."");		
		
		$result = $db->Send_Query("DELETE FROM exo_mp_folders WHERE mfID=$mfID AND mfOwner=".$_SESSION['uid']."");	
		
		$msg = message::getInstance('SUCCESS','Suppression du dossier réussi', 'index.php?comp=mp');
		
	}
	elseif($_POST['action']=='moveFolder'){
		
		$result = $db->Send_Query("DELETE A FROM exo_mp_appartient A, exo_mp_folders F WHERE F.mfID=A.mfID AND A.dpID IN (".$queryFilter.") AND F.mfOwner=".$_SESSION['uid']."");		
		
		foreach($tabSelectionMPs as $key => $value){
			$rq = $db->Send_Query("INSERT INTO exo_mp_appartient (mfID, dpID) VALUES(".intval($_POST['move_to']).", ".intval($value).")");
		}
				
		$msg = message::getInstance('SUCCESS','MPs déplacé dans le dossier réussi', 'index.php?comp=mp');
		
	}
	elseif($_POST['action']=='delete'){
		
		$result = $db->Send_Query("UPDATE exo_mp_participate SET participe=0 WHERE dpID IN (".$queryFilter.") AND uid=".$_SESSION['uid']."");		
						
		$msg = message::getInstance('SUCCESS','Suppression des MPs réussi', 'index.php?comp=mp');
		
	}
	elseif($_POST['action']=='notread'){
		
		$result = $db->Send_Query("UPDATE exo_mp_participate SET last_msg_vu=0 WHERE dpID IN (".$queryFilter.") AND uid=".$_SESSION['uid']."");		
						
		$msg = message::getInstance('SUCCESS','Marquer non-lu des MPs réussi', 'index.php?comp=mp');
		
	}
	elseif($_POST['action']=='read'){		
		
		foreach($tabSelectionMPs as $key => $value){
			$result = $db->Send_Query("UPDATE exo_mp_participate SET last_msg_vu=(SELECT MAX(mpID) FROM exo_mp_messages WHERE dpID=$value) WHERE dpID=$value AND uid=".$_SESSION['uid']."");		
		}	
						
		$msg = message::getInstance('SUCCESS','Marquer lu des MPs réussi', 'index.php?comp=mp');
		
	}
	
	
}
else{
/*
 * AFFICHAGE DU FORMULAIRE
 *
 * 
*/			
		
	$rq = $db->Send_Query("
					SELECT dpID, dpTitle
					FROM exo_mp_discussions
					WHERE dpID IN ($queryFilter)");
	$MPsToConfirm = $db->loadObjectList($rq);
	
	if(empty($MPsToConfirm) && $action!='addFolder' && $action!='editFolder' && $action!='deleteFolder'){
		$msg = message::getInstance('ERROR','Aucun MP sélectionné', 'index.php?comp=mp');	
	}

	//Affichage du message
	if(!empty($action)){
		if($action=='addFolder'){
			
			$optionsToConfirm .= 'Libellé du dossier: <input type="text" name="folderToAdd" />';
		
			$messageToConfirm = 'Voulez-vous ajouter le dossier';
			$actionToConfirm = '<input type="hidden" name="action" value="addFolder" />';
			
		}
		elseif($action=='editFolder'){
			$mfID = intval($_GET['mfID']);
			
			$array = $db->get_array($db->Send_Query("SELECT mfLibelle FROM exo_mp_folders WHERE mfID=$mfID"));
			
			$optionsToConfirm .= 'Libellé du dossier: <input type="text" name="folderToEdit" value="'.stripslashes(htmlspecialchars($array['mfLibelle'])).'" />
			<input type="hidden" name="mfID" value="'.$mfID.'" />
			';
		
			$messageToConfirm = 'Voulez-vous editer le dossier';
			$actionToConfirm = '<input type="hidden" name="action" value="editFolder" />';
		}
		elseif($action=='deleteFolder'){
			$mfID = intval($_GET['mfID']);
			
			$array = $db->get_array($db->Send_Query("SELECT mfLibelle FROM exo_mp_folders WHERE mfID=$mfID"));
			
			$optionsToConfirm .= '<input type="hidden" name="mfID" value="'.$mfID.'" />';
		
			$messageToConfirm = 'Voulez-vous supprimer le dossier <b>'.stripslashes(htmlspecialchars($array['mfLibelle'])).'</b>';
			$actionToConfirm = '<input type="hidden" name="action" value="deleteFolder" />';
		}
		elseif($action=='moveFolder'){
			
			$rq = $db->Send_Query("SELECT mfID, mfLibelle FROM exo_mp_folders WHERE mfOwner=".$_SESSION['uid']);
			$liste = $db->loadObjectList($rq);
			
			$optionsToConfirm .= 'Déplacer les MPs vers <select name="move_to"><option value="0">Aucun dossier</option>';
			
			foreach($liste as $fold){
				$optionsToConfirm .= '<option value="'.$fold->mfID.'">'.$fold->mfLibelle.'</option>';
			}
			$optionsToConfirm .= '</select>';
		
			$messageToConfirm = 'Voulez-vous déplacer les MPs sélectionnés';
			$actionToConfirm = '<input type="hidden" name="action" value="moveFolder" />';
		}
		elseif($action=='delete'){
					
			$messageToConfirm = 'Voulez-vous supprimer les MPs sélectionnés';
			$actionToConfirm = '<input type="hidden" name="action" value="delete" />';
		}
		elseif($action=='notread'){
					
			$messageToConfirm = 'Voulez-vous marquer non-lu les MPs sélectionnés';
			$actionToConfirm = '<input type="hidden" name="action" value="notread" />';
		}
		elseif($action=='read'){
					
			$messageToConfirm = 'Voulez-vous marquer lu les MPs sélectionnés';
			$actionToConfirm = '<input type="hidden" name="action" value="read" />';
		}
		else{
			$msg = message::getInstance('ERROR','Action inconnue', 'index.php?comp=mp');
		}
	}
	else{
		$msg = message::getInstance('ERROR','Aucune action demandée', 'index.php?comp=mp');	
	}
}


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'forum';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Forum' => 'index.php?comp=forum_index',
'Modération' => ''
);  
$ws_name_perso = 'Evoxis v5 - Forum - '.$posts[0]->topic_subject.' - Modération';
?>
