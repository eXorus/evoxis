<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_FORUM_TOPIC_MODERATE', 1 );


if($secureObject->verifyAuthorization('FO_FORUM_TOPIC_MODERATE')!=TRUE){
	$msg = message::getInstance('ERROR','Acc�s interdit', 'index.php?comp=forum_index');
}

/*
 * RECUPERATION DES MESSAGES A TRAITER 
 *
 * 
*/



$tabSelectionMessages = array();
if(!empty($_POST['action'])){
	$action = $_POST['action'];
	
	foreach($_POST as $key => $value){
		if(substr_count($key, "pid_")==1 && $value=="on"){
			array_push($tabSelectionMessages, intval(substr($key,4)));
		}
	}
}
elseif(!empty($_GET['action'])){
	$action = $_GET['action'];
	
	array_push($tabSelectionMessages, intval($_GET['pid']));
}

$queryFilter = '';
foreach($tabSelectionMessages as $key => $value){
	if($queryFilter!='') $queryFilter .= ', ';
	$queryFilter .= $value;
}

$array = $db->get_array($db->Send_Query("SELECT P.tid, T.bid FROM exo_forum_posts P LEFT JOIN exo_forum_topics T ON T.tid=P.tid WHERE pid IN ($queryFilter)"));
$tid = $array['tid'];	
$bid = $array['bid'];

if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$bid.'_MODERATE')!=TRUE){
	$msg = message::getInstance('ERROR', 'Droits insuffisants pour acc�der � ce forum.', './index.php?comp=forum_index');
}
/*
 * TRAITEMENT DES ACTIONS DEMANDEES
 *
 * 
*/
if(!empty($_GET['task']) && $_GET['task']=="process" && !empty($_POST['action']) && !empty($queryFilter)){
	
	if($_POST['action']=='delete'){
		
		$report = mysql_real_escape_string($_POST['reason']);
		
		foreach($tabSelectionMessages as $key => $value){
			$result = $db->Send_Query("INSERT INTO exo_forum_messages(mid, type, message, author, date) VALUES($value, 'POST_DELETED', '$report', ".$_SESSION['uid'].", NOW())"); 
		}
		
				
		//Spyvo
		$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'Forum', 'Delete Post;ID Post='.$queryFilter);
		
		synchronizeForum();
		
		$msg = message::getInstance('SUCCESS','Suppression des messages r�ussis', 'index.php?comp=forum_topic&select='.$tid);
	}
	elseif($_POST['action']=='split'){
		
		$title = mysql_real_escape_string($_POST['title']);
		
		$r = $db->get_array($db->Send_Query("SELECT bid, type, locked FROM exo_forum_topics WHERE tid=$tid"));
		
		$result = $db->Send_Query("INSERT INTO exo_forum_topics(tid, bid, type, subject, locked) VALUES(NULL, ".$r['bid'].", ".$r['type'].", '$title', ".$r['locked'].")"); 
		$new_tid = $db->last_insert_id();
		
		$result = $db->Send_Query("UPDATE exo_forum_posts SET tid=$new_tid WHERE pid IN ($queryFilter)");
		
		synchronizeForum();
		
		$msg = message::getInstance('SUCCESS','S�paration des messages r�ussis', 'index.php?comp=forum_topic&select='.$tid);
	}
	elseif($_POST['action']=='report'){
				
		require_once("./inc/ask.class.php");				
		
		$report = mysql_real_escape_string($_POST['reason']);
		
		foreach($tabSelectionMessages as $key => $value){
			
			$r = $db->get_array($db->Send_Query("SELECT body FROM exo_forum_posts WHERE pid=$value and tid=$tid"));
			
			$o = new ask();
			$o->ID = "NULL";
			$o->Type = 12;
			$o->Cible = intval($_SESSION['uid']);
			$o->Ask = $report.'\n\n---Post Report�---\n\n'.mysql_real_escape_string($r['body']);
			$o->Link = $ws_domain.'index.php?comp=forum_topic&select='.$tid.'&goto='.$value.'#pid'.$value;
			
			$o->insert();
		}
		
		//Spyvo
		$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'Forum', 'Report Post;ID Post='.$queryFilter);				
		
		$msg = message::getInstance('SUCCESS','Report des messages r�ussis', 'index.php?comp=forum_topic&select='.$tid);
	}
	elseif($_POST['action']=='moderate'){
		
		$new_txt = '';
		$add_avertissements = 0;
		$nb_actions = 0;
		
		if($_POST['_MODERATE_POLITESSE_']=='on'){
			$new_txt .= "Manque de politesse ";
			$add_avertissements += 10;
			$nb_actions++;
		}
		
		if($_POST['_MODERATE_INSULTE_']=='on'){
			$new_txt .= "Insulte ";
			$add_avertissements += 15;
			$nb_actions++;
		}
		
		if($_POST['_MODERATE_ANTI-SMS_']=='on'){
			$new_txt .= "Anti-SMS ";
			$add_avertissements += 5;
			$nb_actions++;
		}
		
		if($_POST['_MODERATE_ILLEGAL_']=='on'){
			$new_txt .= "Sujet � caract�re ill�gal ";
			$add_avertissements += 10;
			$nb_actions++;
		}
		
		if($_POST['_MODERATE_FLOOD_']=='on'){
			$new_txt .= "Flood ";
			$add_avertissements += 5;
			$nb_actions++;
		}
		
		if($_POST['_MODERATE_PUBLICITE_']=='on'){
			$new_txt .= "Publicit� ";
			$add_avertissements += 5;
			$nb_actions++;
		}
		
		if($_POST['_MODERATE_HORS-SUJET_']=='on'){
			$new_txt .= "Hors-Sujet ";
			$add_avertissements += 5;
			$nb_actions++;
		}
		
		if($_POST['_MODERATE_DIVERS_']=='on'){
			$new_txt .= "Divers ";
			$add_avertissements += 5;
			$nb_actions++;
		}	
			
		foreach($tabSelectionMessages as $key => $value){
			$result = $db->Send_Query("INSERT INTO exo_forum_messages(mid, type, message, author, date) VALUES($value, 'POST_MODERATED', '$new_txt', ".$_SESSION['uid'].", NOW())"); 
			
			
			$o = $db->get_array($db->Send_Query("SELECT author FROM exo_forum_posts WHERE pid=$value"));
			$uid = mysql_real_escape_string($o['author']);
	
			//Update user
			update_ivo('avertissements', $uid, $add_avertissements);
					
			//Envoie d'un MP
			$data = array();
			$data[0] = '[url='.$ws_domain.'index.php?comp=profil&select='.$_SESSION['uid'].']'.$_SESSION['username'].'[/url]';
			$data[1] = '+';
			$data[2] = $add_avertissements;
			$data[3] = '[url='.$ws_domain.'index.php?comp=forum_topic&select='.$tid.'&goto='.$value.'#pid'.$value.']'.$ws_domain.'index.php?comp=forum_topic&select='.$tid.'&goto='.$value.'#pid'.$value.'[/url]';
			$data[4] = $new_txt;		
			sendAutoMP(1, $uid, $data);
		}
		
		$msg = message::getInstance('SUCCESS','Mod�ration des messages r�ussies', 'index.php?comp=forum_topic&select='.intval($tid));
	}
	
}
else{
/*
 * AFFICHAGE DU FORMULAIRE
 *
 * 
*/
	if(!empty($tid)){				
		
		$rq = $db->Send_Query("
						SELECT U.pseudo, U.username, P.body, P.pid, P.post_time
						FROM exo_forum_posts P
						LEFT JOIN exo_forum_topics T ON T.tid = P.tid
						LEFT JOIN exo_users U ON U.uid=P.author
						WHERE P.pid IN ($queryFilter)");
		$messagesToConfirm = $db->loadObjectList($rq);
		
		if(empty($messagesToConfirm)){
			$msg = message::getInstance('ERROR','Aucun message s�lectionn�', 'index.php?comp=forum_topic&select='.$tid);	
		}

		//Affichage du message
		if(!empty($action)){
			if($action=='delete'){
				$messageToConfirm = 'Voulez-vous supprimer les messages s�lectionn�s';
				
				$optionsToConfirm = '<label for="reason">Raison: </label> : <input type="text" name="reason" id="reason" />';
				
				$actionToConfirm = '<input type="hidden" name="action" value="delete" />';
			}
			elseif($action=='report'){
				$messageToConfirm = 'Voulez-vous reporter les messages s�lectionn�s';
				
				$optionsToConfirm = '<label for="reason">Raison: </label> : <input type="text" name="reason" id="reason" />';
				
				$actionToConfirm = '<input type="hidden" name="action" value="report" />';
			}
			elseif($action=='split'){
				$messageToConfirm = 'Voulez-vous s�parer les messages s�lectionn�s';
				
				$optionsToConfirm = '<label for="title">Titre du nouveau sujet: </label> : <input type="text" name="title" id="title" />';
				
				$actionToConfirm = '<input type="hidden" name="action" value="split" />';
			}
			else if($action=='moderate'){
				$messageToConfirm = 'Voulez-vous mod�rer les messages s�lectionn�s';
				
				$optionsToConfirm = '
					<input name="_MODERATE_POLITESSE_" type="checkbox"> Manque de politesse <i>(+10% d\'avertissement)</i> <br />
					<input name="_MODERATE_INSULTE_" type="checkbox"> Insulte <i>(+15% d\'avertissement)</i> <br />
					<input name="_MODERATE_ANTI-SMS_" type="checkbox"> Anti-SMS <i>(+5% d\'avertissement)</i> <br />
					<input name="_MODERATE_ILLEGAL_" type="checkbox"> Sujet � caract�re ill�gal <i>(+10% d\'avertissement)</i> <br />
					<input name="_MODERATE_FLOOD_" type="checkbox"> Flood <i>(+5% d\'avertissement)</i> <br />
					<input name="_MODERATE_PUBLICITE_" type="checkbox"> Publicit� <i>(+5% d\'avertissement)</i> <br />
					<input name="_MODERATE_HORS-SUJET_" type="checkbox"> Hors-Sujet <i>(+5% d\'avertissement)</i> <br />
					<input name="_MODERATE_DIVERS_" type="checkbox"> Divers <i>(+5% d\'avertissement)</i> <br />

				';
				
				$actionToConfirm = '<input type="hidden" name="action" value="moderate" />';
			}
			else{
				$msg = message::getInstance('ERROR','Action inconnue', 'index.php?comp=forum_topic&select='.$tid);
			}
		}
		else{
			$msg = message::getInstance('ERROR','Aucune action demand�e', 'index.php?comp=forum_topic&select='.$tid);	
		}
	}
	else{
		$msg = message::getInstance('ERROR','Mod�ration impossible', 'index.php?comp=forum_index');	
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
'Mod�ration' => ''
);  
$ws_name_perso = 'Evoxis v5 - Forum - '.$posts[0]->topic_subject.' - Mod�ration';
?>
