<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_FORUM_ADMIN
define( '_VALID_CORE_FORUM_BOARD_MODERATE', 1 );


/*
 * RECUPERATION DES SUJETS A TRAITER 
 *
 * 
*/



$tabSelectionTopics = array();
if(!empty($_POST['action'])){
	$action = $_POST['action'];
	
	foreach($_POST as $key => $value){
		if(substr_count($key, "tid_")==1 && $value=="on"){
			array_push($tabSelectionTopics, intval(substr($key,4)));
		}
	}
}
elseif(!empty($_GET['action'])){
	$action = $_GET['action'];
	
	array_push($tabSelectionTopics, intval($_GET['tid']));
}

$queryFilter = '';
foreach($tabSelectionTopics as $key => $value){
	if($queryFilter!='') $queryFilter .= ', ';
	$queryFilter .= $value;
}

$array = $db->get_array($db->Send_Query("SELECT bid FROM exo_forum_topics WHERE tid IN ($queryFilter)"));
$bid = $array['bid'];	

if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$bid.'_MODERATE')!=TRUE){
	$msg = message::getInstance('ERROR', 'Droits insuffisants pour accéder à ce forum.', './index.php?comp=forum_index');
}

/*
 * TRAITEMENT DES ACTIONS DEMANDEES
 *
 * 
*/
if(!empty($_GET['task']) && $_GET['task']=="process" && !empty($_POST['action']) && !empty($queryFilter)){
	
	if($_POST['action']=='move' && !empty($_POST['move_to'])){
		
		$result = $db->Send_Query("DELETE FROM exo_forum_tag_assoc WHERE topic IN (".$queryFilter.")");		
		$result = $db->Send_Query("UPDATE exo_forum_topics SET bid=".intval($_POST['move_to'])." WHERE tid IN (".$queryFilter.")");
		
		synchronizeForum();
		
		$msg = message::getInstance('SUCCESS','Déplacement des sujets réussies', 'index.php?comp=forum_board&select='.intval($_POST['move_to']));
	
	}
	elseif($_POST['action']=='delete'){
		
		$result = $db->Send_Query("UPDATE exo_forum_topics SET type=9 WHERE tid IN ($queryFilter)");
				
		//Spyvo
		$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'Forum', 'Delete Topic;ID Topic='.$queryFilter);
		
		synchronizeForum();
		
		$msg = message::getInstance('SUCCESS','Suppression des sujets réussies', 'index.php?comp=forum_board&select='.$bid);
	}
	elseif($_POST['action']=='merge'){
		
		//Selection du topic le plus vieux
		$array = $db->get_array($db->Send_Query("SELECT MIN(tid) as mintid FROM exo_forum_topics WHERE tid IN ($queryFilter) GROUP BY bid"));
		$mintid = $array['mintid'];	
		
		$result = $db->Send_Query("UPDATE exo_forum_topics SET type=9 WHERE tid IN ($queryFilter) AND tid !=$mintid");
		$result = $db->Send_Query("UPDATE exo_forum_posts SET tid=$mintid WHERE tid IN ($queryFilter)");  
		
		synchronizeForum();
		
		$msg = message::getInstance('SUCCESS','Fusion des sujets réussies', 'index.php?comp=forum_board&select='.intval($bid));
	}
	elseif($_POST['action']=='notread'){
						
		$result = $db->Send_Query("DELETE FROM exo_lu_forum WHERE uid=".$_SESSION['uid']." AND tid IN ($queryFilter)");  
		
		$msg = message::getInstance('SUCCESS','Marquage en non-lu des sujets réussies', 'index.php?comp=forum_board&select='.intval($bid));
	}
	elseif($_POST['action']=='unlock'){
						
		$result = $db->Send_Query("UPDATE exo_forum_topics SET locked=0 WHERE tid IN ($queryFilter)");
		
		$msg = message::getInstance('SUCCESS','Déverrouillage des sujets réussies', 'index.php?comp=forum_board&select='.intval($bid));
	}
	elseif($_POST['action']=='lock'){
						
		$result = $db->Send_Query("UPDATE exo_forum_topics SET locked=1 WHERE tid IN ($queryFilter)");
		
		$msg = message::getInstance('SUCCESS','Déverrouillage des sujets réussies', 'index.php?comp=forum_board&select='.intval($bid));
	}
	elseif($_POST['action']=='announce'){
						
		$result = $db->Send_Query("UPDATE exo_forum_topics SET type=1 WHERE tid IN ($queryFilter)");
		
		$msg = message::getInstance('SUCCESS','Changement des sujets en annonce réussies', 'index.php?comp=forum_board&select='.intval($bid));
	}
	elseif($_POST['action']=='standard'){
						
		$result = $db->Send_Query("UPDATE exo_forum_topics SET type=0 WHERE tid IN ($queryFilter)");
		
		$msg = message::getInstance('SUCCESS','Changement des sujets en standard réussies', 'index.php?comp=forum_board&select='.intval($bid));
	}
	elseif($_POST['action']=='tagAdd' && !empty($_POST['idtag'])){
						
		foreach($tabSelectionTopics as $key => $value){
			$rq = $db->Send_Query("INSERT INTO exo_forum_tag_assoc (tag, topic) VALUES(".intval($_POST['idtag']).", ".intval($value).")");
		}
		
		
		$msg = message::getInstance('SUCCESS','Ajout du tag aux sujets réussies', 'index.php?comp=forum_board&select='.intval($bid));
	}
	elseif($_POST['action']=='tagDel' && !empty($_POST['idtag'])){
				
		$rq = $db->Send_Query("DELETE FROM exo_forum_tag_assoc WHERE tag=".intval($_POST['idtag'])." AND topic IN ($queryFilter)");
					
		
		$msg = message::getInstance('SUCCESS','Suppression du tag aux sujets réussies', 'index.php?comp=forum_board&select='.intval($bid));
	}
	
}
else{
/*
 * AFFICHAGE DU FORMULAIRE
 *
 * 
*/
	if(!empty($bid)){				
		
		$rq = $db->Send_Query("
						SELECT B.board_name, T.tid, T.subject
						FROM exo_forum_topics T
						LEFT JOIN exo_forum_boards B ON B.bid = T.bid
						WHERE T.tid IN ($queryFilter)");
		$topicsToConfirm = $db->loadObjectList($rq);
		
		if(empty($topicsToConfirm)){
			$msg = message::getInstance('ERROR','Aucun sujet sélectionné', 'index.php?comp=forum_board&select='.$bid);	
		}

		//Affichage du message
		if(!empty($action)){
			if($action=='move'){
					
				$rq = $db->Send_Query("
						SELECT b.catid, c.cat_name, b.board_name, b.bid
						FROM exo_forum_boards b
						LEFT JOIN exo_forum_categories c ON b.catid = c.catid
						ORDER BY c.disp_position, b.disp_position");
				$liste = $db->loadObjectList($rq);
				
				$cat_current = 0;
				
				$optionsToConfirm .= '
				Déplacer ces sujets de <strong>'.stripslashes(htmlspecialchars($topicsToConfirm[0]->board_name)).'</strong> à <select name="move_to">';
				foreach($liste as $object){
					if($object->catid != $cat_current){
						if($cat_current!=0){
							$optionsToConfirm .= '</optgroup>';
						}
					$optionsToConfirm .= '<optgroup label="'.$object->cat_name.'">';
					$cat_current = $object->catid;
					}
					if($bid==$object->bid){
						$optionsToConfirm .= '<option value="'.$object->bid.'" selected="selected">'.$object->board_name.'</option>';
					}
					else{
						$optionsToConfirm .= '<option value="'.$object->bid.'">'.$object->board_name.'</option>';
					}
					
				}
				$optionsToConfirm .= '</select>';
			
				$messageToConfirm = 'Voulez-vous déplacer les sujets sélectionnés';
				$actionToConfirm = '<input type="hidden" name="action" value="move" />';
				
			}
			else if($action=='delete'){
				$messageToConfirm = 'Voulez-vous supprimer les sujets sélectionnés';
				$actionToConfirm = '<input type="hidden" name="action" value="delete" />';
			}
			else if($action=='notread'){
				$messageToConfirm = 'Voulez-vous marquer en non-lu les sujets sélectionnés';
				$actionToConfirm = '<input type="hidden" name="action" value="notread" />';
			}
			else if($action=='merge'){
				$messageToConfirm = 'Voulez-vous fusionner les sujets sélectionnés';
				$actionToConfirm = '<input type="hidden" name="action" value="merge" />';
			}
			else if($action=='unlock'){
				$messageToConfirm = 'Voulez-vous déverrouiller les sujets sélectionnés';
				$actionToConfirm = '<input type="hidden" name="action" value="unlock" />';
			}
			else if($action=='lock'){
				$messageToConfirm = 'Voulez-vous verrouiller les sujets sélectionnés';
				$actionToConfirm = '<input type="hidden" name="action" value="lock" />';
			}
			else if($action=='announce'){
				$messageToConfirm = 'Voulez-vous passer en annonce les sujets sélectionnés';
				$actionToConfirm = '<input type="hidden" name="action" value="announce" />';
			}
			else if($action=='standard'){
				$messageToConfirm = 'Voulez-vous passer en standard les sujets sélectionnés';
				$actionToConfirm = '<input type="hidden" name="action" value="standard" />';
			}
			else if(substr_count($action, "tagAdd_")==1){		
				$idtag = intval(substr($_POST['action'],7));						
				$array = $db->get_array($db->Send_Query("SELECT title FROM exo_forum_tags WHERE tag_id=$idtag"));
				$title = $array['title'];	
				$messageToConfirm = 'Voulez-vous ajouter le tag "'.htmlspecialchars($title).'" pour les sujets sélectionnés';
				$actionToConfirm = '<input type="hidden" name="action" value="tagAdd" /><input type="hidden" name="idtag" value="'.$idtag.'" />';
			}
			else if(substr_count($action, "tagDel_")==1){		
				$idtag = intval(substr($_POST['action'],7));						
				$array = $db->get_array($db->Send_Query("SELECT title FROM exo_forum_tags WHERE tag_id=$idtag"));
				$title = $array['title'];	
				$messageToConfirm = 'Voulez-vous supprimer le tag "'.htmlspecialchars($title).'" pour les sujets sélectionnés';
				$actionToConfirm = '<input type="hidden" name="action" value="tagDel" /><input type="hidden" name="idtag" value="'.$idtag.'" />';
			}
			else{
				$msg = message::getInstance('ERROR','Action inconnue', 'index.php?comp=forum_board&select='.$bid);
			}
		}
		else{
			$msg = message::getInstance('ERROR','Aucune action demandée', 'index.php?comp=forum_board&select='.$bid);	
		}
	}
	else{
		$msg = message::getInstance('ERROR','Modération impossible', 'index.php?comp=forum_index');	
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
